<?php

namespace Modules\Notifications\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Modules\Notifications\Channels\Contracts\ChannelResolverInterface;
use Modules\Notifications\EventBus\EventBusInterface;
use Modules\Notifications\Engines\DeliveryEngine;
use Modules\Notifications\Engines\NotificationEventEngine;
use Modules\Notifications\Models\NotificationPreference;
use Modules\Notifications\Models\NotificationRecord;
use Modules\Notifications\Registry\NotificationRegistry;
use Modules\Notifications\Repositories\Contracts\NotificationRepositoryInterface;
use Modules\Notifications\Resolvers\Contracts\RecipientResolverInterface;
use Modules\Users\Models\User;

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

    public function list(User $user, array $filters): LengthAwarePaginator
    {
        $started = microtime(true);
        $paginator = $this->notifications->paginateForUser($user, $filters, $this->perPage($filters));
        $this->logAction($user, 'list', null, $started, 'success');

        return $paginator;
    }

    public function detail(User $user, string $notificationId): NotificationRecord
    {
        $started = microtime(true);
        $record = $this->recordForUser($user, $notificationId);
        $this->logAction($user, 'detail', $record->uuid, $started, 'success');

        return $record;
    }

    public function markAsRead(User $user, string $notificationId): NotificationRecord
    {
        $started = microtime(true);
        $record = $this->recordForUser($user, $notificationId);
        $this->ensureTransition($record, ['delivered', 'sent'], 'read');

        $record = $this->notifications->updateRecordStatus($record, 'read', ['action' => 'mark_as_read']);
        $record->forceFill(['read_at' => now()])->save();
        $this->notifications->addHistory($record, [
            'status' => 'read',
            'attempt' => $record->attempts,
            'metadata' => ['action' => 'mark_as_read'],
            'read_at' => now(),
        ]);
        $this->logAction($user, 'mark_as_read', $record->uuid, $started, 'success');

        return $record->refresh();
    }

    public function markAllAsRead(User $user): array
    {
        $started = microtime(true);
        $affected = $this->notifications->markAllReadableAsRead($user);
        $this->logAction($user, 'mark_all_as_read', null, $started, 'success');

        return ['updated_count' => $affected];
    }

    public function archive(User $user, string $notificationId): NotificationRecord
    {
        $started = microtime(true);
        $record = $this->recordForUser($user, $notificationId);
        $this->ensureTransition($record, ['read'], 'archived');

        $record = $this->notifications->updateRecordStatus($record, 'archived', ['action' => 'archive']);
        $record->forceFill(['archived_at' => now()])->save();
        $this->notifications->addHistory($record, [
            'status' => 'archived',
            'attempt' => $record->attempts,
            'metadata' => ['action' => 'archive'],
        ]);
        $this->logAction($user, 'archive', $record->uuid, $started, 'success');

        return $record->refresh();
    }

    public function archiveAll(User $user): array
    {
        $started = microtime(true);
        $affected = $this->notifications->archiveAllRead($user);
        $this->logAction($user, 'archive_all_read', null, $started, 'success');

        return ['updated_count' => $affected];
    }

    public function delete(User $user, string $notificationId): array
    {
        $started = microtime(true);
        $record = $this->recordForUser($user, $notificationId);

        if (($record->metadata['system_protected'] ?? false) === true) {
            throw ValidationException::withMessages([
                'notification' => ['System protected notification cannot be deleted.'],
            ]);
        }

        $this->notifications->deleteRecord($record);
        $this->logAction($user, 'delete', $record->uuid, $started, 'success');

        return ['deleted' => true];
    }

    public function preferences(User $user): NotificationPreference
    {
        $started = microtime(true);
        $preference = $this->notifications->preferenceForUser($user);
        $this->logAction($user, 'preferences', null, $started, 'success');

        return $preference;
    }

    public function updatePreferences(User $user, array $payload): NotificationPreference
    {
        $started = microtime(true);
        $preference = $this->notifications->updatePreference($user, $payload);
        $this->logAction($user, 'update_preferences', null, $started, 'success');

        return $preference;
    }

    public function history(User $user, array $filters): LengthAwarePaginator
    {
        $started = microtime(true);
        $paginator = $this->notifications->historyForUser($user, $filters, $this->perPage($filters));
        $this->logAction($user, 'history', null, $started, 'success');

        return $paginator;
    }

    public function statistics(User $user, array $filters): array
    {
        $started = microtime(true);
        $statistics = $this->notifications->statisticsForUser($user, $filters);
        $this->logAction($user, 'statistics', null, $started, 'success');

        return $statistics;
    }

    public function retry(User $user, string $notificationId): NotificationRecord
    {
        $started = microtime(true);
        $record = $this->recordForUser($user, $notificationId);
        $this->ensureTransition($record, ['failed'], 'retry');

        $record = $this->notifications->updateRecordStatus($record, 'retry', ['action' => 'retry_requested']);
        $this->notifications->addHistory($record, [
            'status' => 'retry',
            'attempt' => $record->attempts,
            'metadata' => [
                'action' => 'retry_requested',
                'external_delivery_enabled' => false,
            ],
        ]);
        $this->logAction($user, 'retry', $record->uuid, $started, 'success');

        return $record->refresh();
    }

    public function registry(): array
    {
        return [
            'definitions' => array_map(
                fn ($definition): array => $definition->toArray(),
                $this->registry->all()
            ),
            'definition_count' => count($this->registry->all()),
        ];
    }

    public function templates(): array
    {
        return array_map(fn ($template): array => [
            'id' => $template->uuid,
            'channel' => $template->channel,
            'name' => $template->name,
            'subject' => $template->subject,
            'body' => $template->body,
            'is_active' => $template->is_active,
        ], $this->notifications->activeTemplates());
    }

    public function exportMetadata(User $user, array $filters): array
    {
        $started = microtime(true);
        $format = $filters['format'] ?? 'csv';
        $estimated = $this->notifications->countForUser($user, $filters);
        $this->logAction($user, 'export_metadata', null, $started, 'success');

        return [
            'supported_formats' => ['pdf', 'xlsx', 'csv', 'json'],
            'selected_format' => $format,
            'filter_summary' => array_filter($filters, fn ($value): bool => $value !== null && $value !== ''),
            'estimated_record_count' => $estimated,
            'suggested_filename' => 'notification-history-'.now()->format('Ymd-His').'.'.$format,
            'production_file_generation' => false,
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

    private function recordForUser(User $user, string $notificationId): NotificationRecord
    {
        $record = $this->notifications->findForUser($user, $notificationId);

        if (! $record) {
            abort(404, 'Notification not found.');
        }

        return $record;
    }

    /** @param array<int, string> $allowedFrom */
    private function ensureTransition(NotificationRecord $record, array $allowedFrom, string $target): void
    {
        if (! in_array($record->status, $allowedFrom, true)) {
            throw ValidationException::withMessages([
                'status' => ["Cannot transition notification from {$record->status} to {$target}."],
            ]);
        }
    }

    private function perPage(array $filters): int
    {
        return min(max((int) ($filters['per_page'] ?? 15), 1), 100);
    }

    private function logAction(User $user, string $action, ?string $notificationId, float $started, string $status): void
    {
        Log::info('Notification API action executed.', [
            'user_id' => $user->id,
            'notification_id' => $notificationId,
            'action' => $action,
            'execution_time_ms' => round((microtime(true) - $started) * 1000, 2),
            'ip_address' => request()?->ip(),
            'result_status' => $status,
        ]);
    }
}
