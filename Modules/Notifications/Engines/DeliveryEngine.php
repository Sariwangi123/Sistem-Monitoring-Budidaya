<?php

namespace Modules\Notifications\Engines;

use Modules\Notifications\Channels\Contracts\ChannelResolverInterface;
use Modules\Notifications\Contracts\DomainEventInterface;
use Modules\Notifications\Exceptions\DeliveryFailedException;
use Modules\Notifications\Repositories\Contracts\NotificationRepositoryInterface;
use Modules\Notifications\Support\DeliveryResult;
use Modules\Notifications\Support\NotificationDefinition;
use Modules\Notifications\Support\NotificationRecipient;
use Throwable;

final class DeliveryEngine
{
    public function __construct(
        private ChannelResolverInterface $channels,
        private NotificationRepositoryInterface $notifications
    ) {
    }

    public function deliver(NotificationDefinition $definition, DomainEventInterface $event, NotificationRecipient $recipient, string $channel): DeliveryResult
    {
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
            ],
        ]);

        $this->notifications->addHistory($record, [
            'status' => 'pending',
            'attempt' => 1,
            'metadata' => ['stage' => 'queued'],
        ]);

        try {
            $adapter = $this->channels->resolve($channel);
            $result = $adapter->deliver($definition, $event, $recipient);

            $record = $this->notifications->updateRecordStatus($record, $result->status, $result->metadata);
            $this->notifications->addHistory($record, [
                'status' => $result->status,
                'attempt' => $record->attempts,
                'metadata' => $result->metadata,
                'delivered_at' => $result->status === 'delivered' ? now() : null,
            ]);

            return $result;
        } catch (Throwable $exception) {
            $status = $record->attempts + 1 < $definition->retryPolicy->maxAttempts ? 'retry' : 'failed';
            $record = $this->notifications->updateRecordStatus($record, $status, [
                'retry_policy' => $definition->retryPolicy->toArray(),
            ], $exception->getMessage());
            $this->notifications->addHistory($record, [
                'status' => $status,
                'attempt' => $record->attempts,
                'metadata' => ['exception' => $exception::class],
            ]);

            throw DeliveryFailedException::forChannel($channel, $exception);
        }
    }
}
