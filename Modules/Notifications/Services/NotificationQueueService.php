<?php

namespace Modules\Notifications\Services;

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Modules\Notifications\Contracts\DomainEventInterface;
use Modules\Notifications\Exceptions\NotificationQueueException;
use Modules\Notifications\Jobs\ProcessNotificationEventJob;
use Throwable;

final class NotificationQueueService
{
    public function dispatch(DomainEventInterface $event): void
    {
        try {
            Bus::dispatch(new ProcessNotificationEventJob($event));
            Log::info('Notification event queued.', ['event_name' => $event->eventName(), 'correlation_id' => $event->correlationId()]);
        } catch (Throwable $exception) {
            throw NotificationQueueException::dispatchFailed($event->eventName(), $exception);
        }
    }

    /** @return array<string, mixed> */
    public function metadata(): array
    {
        return [
            'enabled' => true,
            'job' => ProcessNotificationEventJob::class,
            'mode' => 'asynchronous_ready',
            'requires_production_worker_for_tests' => false,
            'statuses' => ['pending', 'processing', 'delivered', 'failed', 'retry'],
            'retry' => [
                'max_attempts' => 3,
                'interval_seconds' => [60, 120, 180],
            ],
            'dead_letter' => ['metadata_only' => true, 'automatic_replay_enabled' => false],
        ];
    }
}
