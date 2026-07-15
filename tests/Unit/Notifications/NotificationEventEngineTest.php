<?php

namespace Tests\Unit\Notifications;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Notifications\Events\ImmutableDomainEvent;
use Modules\Notifications\Events\Samples\LowStockDetectedEvent;
use Modules\Notifications\Exceptions\EventNotRegisteredException;
use Modules\Notifications\Registry\NotificationRegistry;
use Modules\Notifications\Support\NotificationDefinition;
use Modules\Notifications\Support\RetryPolicy;
use Modules\Notifications\Engines\NotificationEventEngine;
use Modules\Notifications\Models\NotificationHistory;
use Modules\Notifications\Models\NotificationRecord;
use Tests\TestCase;

final class NotificationEventEngineTest extends TestCase
{
    use RefreshDatabase;

    public function test_domain_event_is_immutable_and_exposes_read_only_payload(): void
    {
        $event = new ImmutableDomainEvent(
            'system.backup_completed',
            'System',
            ['status' => 'ok'],
            correlationId: '0f4eb1d0-0000-4000-8000-000000000001'
        );

        $this->assertSame('system.backup_completed', $event->eventName());
        $this->assertSame('System', $event->sourceModule());
        $this->assertSame(['status' => 'ok'], $event->payload());
        $this->assertSame('0f4eb1d0-0000-4000-8000-000000000001', $event->correlationId());
        $this->assertSame($event->occurredAt()->getTimestamp(), $event->occurredAt()->getTimestamp());
    }

    public function test_registry_registers_notification_definition_metadata(): void
    {
        $registry = new NotificationRegistry();
        $registry->register(new NotificationDefinition(
            'system.backup_completed',
            'backup_completed',
            'system',
            'information',
            ['in_app'],
            'role:super-admin',
            'backup-completed',
            new RetryPolicy(),
            '1.0',
            'Backup Completed',
            'System backup has completed.'
        ));

        $definition = $registry->get('system.backup_completed');

        $this->assertSame('system.backup_completed', $definition->eventName);
        $this->assertSame('information', $definition->priority);
        $this->assertSame(['in_app'], $definition->channels);
    }

    public function test_notification_event_engine_delivers_in_app_notification_and_records_history(): void
    {
        $result = app(NotificationEventEngine::class)->process(new LowStockDetectedEvent([
            'inventory_item_id' => 'feed-001',
        ], correlationId: '0f4eb1d0-0000-4000-8000-000000000002'));

        $this->assertSame('inventory.low_stock_detected', $result['event_name']);
        $this->assertSame('Warehouse', $result['source_module']);
        $this->assertSame(1, $result['recipient_count']);
        $this->assertSame('delivered', $result['results'][0]['status']);

        $this->assertDatabaseHas('notification_records', [
            'event_name' => 'inventory.low_stock_detected',
            'channel' => 'in_app',
            'recipient_type' => 'role',
            'recipient_id' => 'warehouse-staff',
            'status' => 'delivered',
        ]);
        $this->assertSame(1, NotificationRecord::query()->count());
        $this->assertSame(2, NotificationHistory::query()->count());
    }

    public function test_unregistered_event_throws_custom_exception(): void
    {
        $this->expectException(EventNotRegisteredException::class);

        app(NotificationEventEngine::class)->process(new ImmutableDomainEvent(
            'unknown.event',
            'System',
            correlationId: '0f4eb1d0-0000-4000-8000-000000000003'
        ));
    }
}
