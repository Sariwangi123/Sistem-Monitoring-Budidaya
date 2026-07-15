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

    public int $backoff = 60;

    public function __construct(private DomainEventInterface $event)
    {
    }

    public function handle(NotificationEventEngine $engine): void
    {
        $engine->process($this->event);
    }
}
