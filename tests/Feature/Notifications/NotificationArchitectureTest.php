<?php

namespace Tests\Feature\Notifications;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Modules\Notifications\Channels\Contracts\ChannelResolverInterface;
use Modules\Notifications\EventBus\EventBusInterface;
use Modules\Notifications\Events\Samples\HarvestCompletedEvent;
use Modules\Notifications\Jobs\ProcessNotificationEventJob;
use Modules\Notifications\Services\NotificationQueueService;
use Tests\TestCase;

final class NotificationArchitectureTest extends TestCase
{
    use RefreshDatabase;

    public function test_event_bus_dispatches_subscribed_domain_event_handler(): void
    {
        $bus = app(EventBusInterface::class);
        $handled = false;

        $bus->subscribe('harvest.completed', function (HarvestCompletedEvent $event) use (&$handled): void {
            $handled = $event->eventName() === 'harvest.completed';
        });

        $bus->publish(new HarvestCompletedEvent(correlationId: '0f4eb1d0-0000-4000-8000-000000000004'));

        $this->assertTrue($handled);
    }

    public function test_queue_service_dispatches_notification_background_job(): void
    {
        Bus::fake();

        app(NotificationQueueService::class)->dispatch(new HarvestCompletedEvent(correlationId: '0f4eb1d0-0000-4000-8000-000000000005'));

        Bus::assertDispatched(ProcessNotificationEventJob::class);
    }

    public function test_channel_resolver_exposes_only_in_app_as_available_channel(): void
    {
        $channels = app(ChannelResolverInterface::class)->supportedChannels();

        $this->assertTrue($channels[0]['available']);
        $this->assertSame('in_app', $channels[0]['key']);
        $this->assertFalse($channels[1]['available']);
        $this->assertTrue($channels[1]['external']);
    }
}
