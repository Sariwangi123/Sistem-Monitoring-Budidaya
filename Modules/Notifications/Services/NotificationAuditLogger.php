<?php

namespace Modules\Notifications\Services;

use Illuminate\Support\Facades\Log;
use Modules\Notifications\Models\NotificationRecord;

final class NotificationAuditLogger
{
    /** @param array<string, mixed> $context */
    public function delivery(NotificationRecord $record, string $status, float $started, array $context = []): void
    {
        Log::info('Notification delivery lifecycle updated.', [
            'notification_id' => $record->uuid,
            'recipient' => $record->recipient_id,
            'channel' => $record->channel,
            'priority' => $record->priority,
            'status' => $status,
            'retry_count' => $record->attempts,
            'execution_time_ms' => round((microtime(true) - $started) * 1000, 2),
            ...$context,
        ]);
    }
}
