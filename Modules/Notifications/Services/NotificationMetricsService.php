<?php

namespace Modules\Notifications\Services;

use Modules\Notifications\Repositories\Contracts\NotificationRepositoryInterface;

final class NotificationMetricsService
{
    public function __construct(private NotificationRepositoryInterface $notifications)
    {
    }

    /** @return array<string, mixed> */
    public function health(): array
    {
        $summary = $this->notifications->centerSummary();
        $pending = $summary['pending_count'];
        $failed = $summary['failed_count'];
        $delivered = $summary['delivered_count'];

        return [
            'status' => $failed > 0 ? 'degraded' : 'healthy',
            'queue' => ['pending_count' => $pending, 'processing_count' => $summary['processing_count']],
            'delivery' => ['delivered_count' => $delivered, 'failed_count' => $failed],
            'retry' => ['retry_count' => $summary['retry_count'], 'max_attempts' => 3],
            'dead_letter' => ['count' => $summary['dead_letter_count'], 'automatic_replay_enabled' => false],
            'retention' => [
                'automatic_cleanup_enabled' => false,
                'strategy' => 'metadata_only_manual_review',
            ],
        ];
    }
}
