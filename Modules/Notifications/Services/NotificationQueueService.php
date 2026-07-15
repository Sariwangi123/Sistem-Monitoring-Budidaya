<?php

namespace Modules\Notifications\Services;

use Illuminate\Support\Facades\Bus;
use Modules\Notifications\Contracts\DomainEventInterface;
use Modules\Notifications\Jobs\ProcessNotificationEventJob;

final class NotificationQueueService
{
    public function dispatch(DomainEventInterface $event): void
    {
        Bus::dispatch(new ProcessNotificationEventJob($event));
    }

    /** @return array<string, mixed> */
    public function metadata(): array
    {
        return [
            'enabled' => true,
            'job' => ProcessNotificationEventJob::class,
            'mode' => 'foundation',
            'requires_production_worker_for_tests' => false,
            'statuses' => ['pending', 'processing', 'delivered', 'failed', 'retry'],
            'retry' => [
                'max_attempts' => 3,
                'interval_seconds' => 60,
            ],
        ];
    }
}
