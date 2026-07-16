<?php

namespace Modules\Notifications\Support;

use Illuminate\Support\Carbon;

final readonly class NotificationRetentionPolicy
{
    public function __construct(public int $archiveAfterDays = 90, public int $expireAfterDays = 365)
    {
    }

    /** @return array<string, mixed> */
    public function metadata(?Carbon $createdAt = null): array
    {
        $createdAt ??= now();

        return [
            'archive_after_days' => $this->archiveAfterDays,
            'expires_at' => $createdAt->copy()->addDays($this->expireAfterDays)->toIso8601String(),
            'automatic_cleanup_enabled' => false,
            'cleanup_strategy' => 'manual_review_only',
        ];
    }
}
