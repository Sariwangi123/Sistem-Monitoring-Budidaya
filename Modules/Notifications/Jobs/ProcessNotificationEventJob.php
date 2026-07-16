<?php

namespace Modules\Notifications\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Notifications\Contracts\DomainEventInterface;
use Modules\Notifications\Engines\NotificationEventEngine;

final class ProcessNotificationEventJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;

    public function backoff(): array
    {
        return [60, 120, 180];
    }

    public function __construct(private DomainEventInterface $event)
    {
    }

    public function handle(NotificationEventEngine $engine): void
    {
        $engine->process($this->event);
    }

    public function failed(\Throwable $exception): void
    {
        \Illuminate\Support\Facades\Log::warning('Notification queue job exhausted retries.', [
            'event_name' => $this->event->eventName(),
            'correlation_id' => $this->event->correlationId(),
            'exception' => $exception::class,
            'dead_letter_metadata_only' => true,
        ]);
    }
}
