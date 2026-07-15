<?php

namespace Modules\Notifications\Services;

use Modules\Notifications\Repositories\Contracts\NotificationRepositoryInterface;

final class NotificationService
{
    public function __construct(private NotificationRepositoryInterface $notifications)
    {
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
            'architecture' => [
                'controller' => 'Modules\\Notifications\\Controllers\\NotificationController',
                'service' => self::class,
                'repository' => NotificationRepositoryInterface::class,
                'event_bus' => false,
                'delivery_engine' => false,
                'queue_worker' => false,
                'frontend_notification_center' => false,
            ],
            'roles' => $roleSlugs,
            'business_rules' => [
                'does_not_create_business_transaction',
                'does_not_update_business_transaction',
                'does_not_delete_business_transaction',
                'does_not_send_email_or_external_channel_in_part_1',
                'business_module_integration_deferred_to_next_part',
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
        ];
    }

    private function channels(): array
    {
        return [
            $this->channel('in_app', 'In-App', true),
            $this->channel('email', 'Email', false),
            $this->channel('whatsapp', 'WhatsApp', false),
            $this->channel('telegram', 'Telegram', false),
            $this->channel('push_notification', 'Push Notification', false),
            $this->channel('sms', 'SMS', false),
        ];
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
