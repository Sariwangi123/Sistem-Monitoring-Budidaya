<?php

namespace Modules\Notifications\Services;

use Modules\Notifications\Channels\Contracts\ChannelResolverInterface;
use Modules\Notifications\EventBus\EventBusInterface;
use Modules\Notifications\Engines\DeliveryEngine;
use Modules\Notifications\Engines\NotificationEventEngine;
use Modules\Notifications\Registry\NotificationRegistry;
use Modules\Notifications\Repositories\Contracts\NotificationRepositoryInterface;
use Modules\Notifications\Resolvers\Contracts\RecipientResolverInterface;

final class NotificationService
{
    public function __construct(
        private NotificationRepositoryInterface $notifications,
        private NotificationRegistry $registry,
        private ChannelResolverInterface $channels,
        private NotificationQueueService $queue
    ) {
    }

    /** @param array<int, string> $roleSlugs */
    public function overview(array $roleSlugs): array
    {
        return [
            'module' => [
                'key' => 'notification',
                'title' => 'Notification Center',
                'description' => 'Communication Platform foundation for system notifications and alerts.',
                'status' => 'Foundation Ready',
                'event_driven_ready' => true,
                'read_only_business_module' => true,
                'creates_business_transaction' => false,
                'updates_business_transaction' => false,
            ],
            'categories' => $this->categories(),
            'priorities' => $this->priorities(),
            'statuses' => $this->statuses(),
            'channels' => $this->channels(),
            'notification_center' => [
                'summary' => $this->notifications->centerSummary(),
                'features' => [
                    'unread_notification',
                    'recent_notification',
                    'critical_alert',
                    'reminder',
                    'notification_history',
                ],
            ],
            'mvp_channel' => [
                'key' => 'in_app',
                'label' => 'In-App',
                'delivery_enabled' => false,
                'description' => 'MVP channel foundation for Notification Center display only.',
            ],
            'future_channels' => ['email', 'whatsapp', 'telegram', 'push_notification', 'sms'],
            'registry' => [
                'definition_count' => count($this->registry->all()),
                'definitions' => array_map(
                    fn ($definition): array => $definition->toArray(),
                    $this->registry->all()
                ),
            ],
            'queue' => $this->queue->metadata(),
            'architecture' => [
                'controller' => 'Modules\\Notifications\\Controllers\\NotificationController',
                'service' => self::class,
                'repository' => NotificationRepositoryInterface::class,
                'event_bus' => EventBusInterface::class,
                'event_engine' => NotificationEventEngine::class,
                'notification_registry' => NotificationRegistry::class,
                'recipient_resolver' => RecipientResolverInterface::class,
                'channel_resolver' => ChannelResolverInterface::class,
                'delivery_engine' => DeliveryEngine::class,
                'queue_worker' => 'foundation_ready',
                'frontend_notification_center' => false,
            ],
            'roles' => $roleSlugs,
            'business_rules' => [
                'does_not_create_business_transaction',
                'does_not_update_business_transaction',
                'does_not_delete_business_transaction',
                'does_not_send_email_or_external_channel',
                'business_module_integration_deferred_to_next_part',
                'external_channel_delivery_disabled',
            ],
        ];
    }

    private function categories(): array
    {
        return [
            $this->definition('operational', 'Operational'),
            $this->definition('inventory', 'Inventory'),
            $this->definition('harvest', 'Harvest'),
            $this->definition('financial', 'Financial'),
            $this->definition('executive', 'Executive'),
            $this->definition('security', 'Security'),
            $this->definition('system', 'System'),
            $this->definition('audit', 'Audit'),
        ];
    }

    private function priorities(): array
    {
        return [
            $this->definition('critical', 'Critical', 1),
            $this->definition('high', 'High', 2),
            $this->definition('medium', 'Medium', 3),
            $this->definition('low', 'Low', 4),
            $this->definition('information', 'Information', 5),
        ];
    }

    private function statuses(): array
    {
        return [
            $this->definition('pending', 'Pending'),
            $this->definition('sent', 'Sent'),
            $this->definition('delivered', 'Delivered'),
            $this->definition('read', 'Read'),
            $this->definition('archived', 'Archived'),
            $this->definition('failed', 'Failed'),
            $this->definition('processing', 'Processing'),
            $this->definition('retry', 'Retry'),
        ];
    }

    private function channels(): array
    {
        return array_map(
            fn (array $channel): array => [
                ...$this->channel($channel['key'], str($channel['key'])->replace('_', ' ')->headline()->toString(), $channel['key'] === 'in_app'),
                'available' => $channel['available'],
                'external' => $channel['external'],
            ],
            $this->channels->supportedChannels()
        );
    }

    private function definition(string $key, string $label, ?int $sortOrder = null): array
    {
        return array_filter([
            'key' => $key,
            'label' => $label,
            'sort_order' => $sortOrder,
        ], fn (mixed $value): bool => $value !== null);
    }

    private function channel(string $key, string $label, bool $mvp): array
    {
        return [
            'key' => $key,
            'label' => $label,
            'mvp' => $mvp,
            'delivery_enabled' => false,
            'foundation_only' => true,
        ];
    }
}
