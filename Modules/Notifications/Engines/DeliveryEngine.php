<?php

namespace Modules\Notifications\Engines;

use Modules\Notifications\Channels\Contracts\ChannelResolverInterface;
use Modules\Notifications\Contracts\DomainEventInterface;
use Modules\Notifications\Exceptions\DeliveryFailedException;
use Modules\Notifications\Repositories\Contracts\NotificationRepositoryInterface;
use Modules\Notifications\Support\DeliveryResult;
use Modules\Notifications\Support\NotificationDefinition;
use Modules\Notifications\Support\NotificationRecipient;
use Modules\Notifications\Support\NotificationRetentionPolicy;
use Modules\Notifications\Services\NotificationAuditLogger;
use Throwable;

final class DeliveryEngine
{
    public function __construct(
        private ChannelResolverInterface $channels,
        private NotificationRepositoryInterface $notifications,
        private NotificationRetentionPolicy $retention,
        private NotificationAuditLogger $audit
    ) {
    }

    public function deliver(NotificationDefinition $definition, DomainEventInterface $event, NotificationRecipient $recipient, string $channel): DeliveryResult
    {
        $started = microtime(true);
        $record = $this->notifications->createRecord([
            'event_name' => $event->eventName(),
            'source_module' => $event->sourceModule(),
            'correlation_id' => $event->correlationId(),
            'notification_type' => $definition->notificationType,
            'category' => $definition->category,
            'priority' => $definition->priority,
            'channel' => $channel,
            'recipient_type' => $recipient->type,
            'recipient_id' => $recipient->identifier,
            'title' => $definition->title,
            'message' => $definition->message,
            'status' => 'pending',
            'attempts' => 0,
            'max_attempts' => $definition->retryPolicy->maxAttempts,
            'metadata' => [
                'event_payload' => $event->payload(),
                'template' => $definition->templateKey,
                'version' => $definition->version,
                'delivery' => ['status' => 'pending', 'external_delivery_enabled' => false],
                'retry' => $definition->retryPolicy->toArray(),
                'retention' => $this->retention->metadata(),
            ],
        ]);

        $this->notifications->addHistory($record, [
            'status' => 'pending',
            'attempt' => 1,
            'metadata' => ['stage' => 'queued'],
        ]);

        $record = $this->notifications->updateRecordStatus($record, 'processing', [
            'delivery' => ['status' => 'processing', 'started_at' => now()->toIso8601String()],
        ], incrementAttempts: true);
        $this->notifications->addHistory($record, [
            'status' => 'processing',
            'attempt' => $record->attempts,
            'metadata' => ['stage' => 'delivery_started'],
        ]);

        try {
            $adapter = $this->channels->resolve($channel);
            $result = $adapter->deliver($definition, $event, $recipient);

            $record = $this->notifications->updateRecordStatus($record, $result->status, [
                'delivery' => [
                    'status' => $result->status,
                    'completed_at' => now()->toIso8601String(),
                    'metadata' => $result->metadata,
                ],
            ]);
            $this->notifications->addHistory($record, [
                'status' => $result->status,
                'attempt' => $record->attempts,
                'metadata' => $result->metadata,
                'delivered_at' => $result->status === 'delivered' ? now() : null,
            ]);
            $this->audit->delivery($record, $result->status, $started, ['event_name' => $event->eventName()]);

            return $result;
        } catch (Throwable $exception) {
            $status = $record->attempts < $definition->retryPolicy->maxAttempts ? 'retry' : 'failed';
            $record = $this->notifications->updateRecordStatus($record, $status, [
                'retry' => [
                    ...$definition->retryPolicy->toArray(),
                    'current_attempt' => $record->attempts,
                    'next_backoff_seconds' => $definition->retryPolicy->backoffSchedule()[$record->attempts - 1] ?? null,
                ],
                'dead_letter' => $status === 'failed' ? [
                    'recorded_at' => now()->toIso8601String(),
                    'automatic_replay_enabled' => false,
                ] : null,
            ], $exception->getMessage());
            $this->notifications->addHistory($record, [
                'status' => $status,
                'attempt' => $record->attempts,
                'metadata' => ['exception' => $exception::class],
            ]);
            $this->audit->delivery($record, $status, $started, ['event_name' => $event->eventName(), 'exception' => $exception::class]);

            throw DeliveryFailedException::forChannel($channel, $exception);
        }
    }
}
