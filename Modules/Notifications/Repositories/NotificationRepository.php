<?php

namespace Modules\Notifications\Repositories;

use Modules\Notifications\Models\NotificationHistory;
use Modules\Notifications\Models\NotificationRecord;
use Modules\Notifications\Models\NotificationTemplate;
use Modules\Notifications\Repositories\Contracts\NotificationRepositoryInterface;

final class NotificationRepository implements NotificationRepositoryInterface
{
    public function __construct(
        private NotificationTemplate $template,
        private NotificationRecord $record,
        private NotificationHistory $history
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
            'delivered_count' => $this->record->newQuery()->where('status', 'delivered')->count(),
            'failed_count' => $this->record->newQuery()->where('status', 'failed')->count(),
            'active_template_count' => $this->template->newQuery()->where('is_active', true)->count(),
        ];
    }

    public function createRecord(array $payload): NotificationRecord
    {
        return $this->record->newQuery()->create($payload);
    }

    public function updateRecordStatus(NotificationRecord $record, string $status, array $metadata = [], ?string $error = null): NotificationRecord
    {
        $record->forceFill([
            'status' => $status,
            'last_error' => $error,
            'metadata' => array_replace($record->metadata ?? [], $metadata),
            'attempts' => $record->attempts + 1,
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
}
