<?php

namespace Modules\Notifications\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Modules\Notifications\Models\NotificationHistory;
use Modules\Notifications\Models\NotificationPreference;
use Modules\Notifications\Models\NotificationRecord;
use Modules\Notifications\Models\NotificationTemplate;
use Modules\Notifications\Repositories\Contracts\NotificationRepositoryInterface;
use Modules\Users\Models\User;

final class NotificationRepository implements NotificationRepositoryInterface
{
    public function __construct(
        private NotificationTemplate $template,
        private NotificationRecord $record,
        private NotificationHistory $history,
        private NotificationPreference $preference
    ) {
    }

    public function centerSummary(): array
    {
        return [
            'unread_count' => 0,
            'recent_count' => 0,
            'critical_count' => 0,
            'reminder_count' => 0,
            'history_count' => $this->history->newQuery()->count(),
            'pending_count' => $this->record->newQuery()->where('status', 'pending')->count(),
            'processing_count' => $this->record->newQuery()->where('status', 'processing')->count(),
            'delivered_count' => $this->record->newQuery()->where('status', 'delivered')->count(),
            'failed_count' => $this->record->newQuery()->where('status', 'failed')->count(),
            'retry_count' => $this->record->newQuery()->where('status', 'retry')->count(),
            'dead_letter_count' => $this->record->newQuery()->where('status', 'failed')->whereNotNull('last_error')->count(),
            'active_template_count' => $this->template->newQuery()->where('is_active', true)->count(),
        ];
    }

    public function paginateForUser(User $user, array $filters, int $perPage): LengthAwarePaginator
    {
        return $this->filteredUserQuery($user, $filters)
            ->orderBy($filters['sort'] ?? 'created_at', $filters['direction'] ?? 'desc')
            ->paginate($perPage);
    }

    public function findForUser(User $user, string $uuid): ?NotificationRecord
    {
        return $this->userScopedQuery($user)
            ->where('uuid', $uuid)
            ->first();
    }

    public function historyForUser(User $user, array $filters, int $perPage): LengthAwarePaginator
    {
        $recordIds = $this->filteredUserQuery($user, $filters)->pluck('id');

        return $this->history->newQuery()
            ->with('record')
            ->whereIn('notification_record_id', $recordIds)
            ->orderBy('created_at', $filters['direction'] ?? 'desc')
            ->paginate($perPage);
    }

    public function countForUser(User $user, array $filters = []): int
    {
        return $this->filteredUserQuery($user, $filters)->count();
    }

    public function statisticsForUser(User $user, array $filters = []): array
    {
        $query = $this->filteredUserQuery($user, $filters);
        $records = $query->get(['category', 'priority', 'status']);

        return [
            'total_notification' => $records->count(),
            'total_unread' => $records->whereNotIn('status', ['read', 'archived'])->count(),
            'total_archived' => $records->where('status', 'archived')->count(),
            'by_category' => $records->groupBy('category')->map->count()->all(),
            'by_priority' => $records->groupBy('priority')->map->count()->all(),
            'by_status' => $records->groupBy('status')->map->count()->all(),
        ];
    }

    public function markAllReadableAsRead(User $user): int
    {
        return $this->userScopedQuery($user)
            ->whereIn('status', ['sent', 'delivered'])
            ->update([
                'status' => 'read',
                'read_at' => now(),
                'updated_at' => now(),
            ]);
    }

    public function archiveAllRead(User $user): int
    {
        return $this->userScopedQuery($user)
            ->where('status', 'read')
            ->update([
                'status' => 'archived',
                'archived_at' => now(),
                'updated_at' => now(),
            ]);
    }

    public function deleteRecord(NotificationRecord $record): void
    {
        $record->delete();
    }

    public function preferenceForUser(User $user): NotificationPreference
    {
        return $this->preference->newQuery()->firstOrCreate(
            ['user_id' => $user->id],
            [
                'in_app_enabled' => true,
                'reminder_enabled' => true,
                'sound_enabled' => true,
                'email_enabled' => false,
                'whatsapp_enabled' => false,
                'desktop_notification_enabled' => false,
            ]
        );
    }

    public function updatePreference(User $user, array $payload): NotificationPreference
    {
        $preference = $this->preferenceForUser($user);
        $preference->fill([
            ...$payload,
            'email_enabled' => false,
            'whatsapp_enabled' => false,
            'desktop_notification_enabled' => false,
            'metadata' => [
                'external_channel_delivery_enabled' => false,
                'updated_via' => 'notification_api',
            ],
        ])->save();

        return $preference->refresh();
    }

    public function activeTemplates(): array
    {
        return $this->template->newQuery()
            ->where('is_active', true)
            ->orderBy('channel')
            ->orderBy('name')
            ->get()
            ->all();
    }

    public function createRecord(array $payload): NotificationRecord
    {
        return $this->record->newQuery()->create($payload);
    }

    public function updateRecordStatus(NotificationRecord $record, string $status, array $metadata = [], ?string $error = null, bool $incrementAttempts = false): NotificationRecord
    {
        $record->forceFill([
            'status' => $status,
            'last_error' => $error,
            'metadata' => array_replace_recursive($record->metadata ?? [], $metadata),
            'attempts' => $incrementAttempts ? $record->attempts + 1 : $record->attempts,
            'delivered_at' => $status === 'delivered' ? now() : $record->delivered_at,
        ])->save();

        return $record->refresh();
    }

    public function addHistory(NotificationRecord $record, array $payload): NotificationHistory
    {
        return $this->history->newQuery()->create([
            ...$payload,
            'notification_record_id' => $record->id,
            'event_name' => $record->event_name,
            'channel' => $record->channel,
            'recipient_type' => $record->recipient_type,
            'recipient_id' => $record->recipient_id,
        ]);
    }

    private function filteredUserQuery(User $user, array $filters): Builder
    {
        $query = $this->userScopedQuery($user);

        foreach (['status', 'category', 'priority', 'channel', 'source_module'] as $field) {
            if (! empty($filters[$field])) {
                $query->where($field, $filters[$field]);
            }
        }

        if (filter_var($filters['unread_only'] ?? false, FILTER_VALIDATE_BOOLEAN)) {
            $query->whereNotIn('status', ['read', 'archived']);
        }

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function (Builder $builder) use ($search): void {
                $builder->where('title', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('event_name', 'like', "%{$search}%");
            });
        }

        if (! empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (! empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        return $query;
    }

    private function userScopedQuery(User $user): Builder
    {
        $roleSlugs = $user->roles()->pluck('slug')->all();

        return $this->record->newQuery()
            ->where(function (Builder $query) use ($user, $roleSlugs): void {
                $query->where(function (Builder $userQuery) use ($user): void {
                    $userQuery->where('recipient_type', 'user')
                        ->whereIn('recipient_id', [(string) $user->id, (string) $user->uuid]);
                });

                if ($roleSlugs !== []) {
                    $query->orWhere(function (Builder $roleQuery) use ($roleSlugs): void {
                        $roleQuery->where('recipient_type', 'role')
                            ->whereIn('recipient_id', $roleSlugs);
                    });
                }
            });
    }
}
