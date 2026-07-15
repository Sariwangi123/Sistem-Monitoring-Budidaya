<?php

namespace Modules\Notifications\Repositories;

use Modules\Notifications\Models\NotificationTemplate;
use Modules\Notifications\Repositories\Contracts\NotificationRepositoryInterface;

final class NotificationRepository implements NotificationRepositoryInterface
{
    public function __construct(private NotificationTemplate $template)
    {
    }

    public function centerSummary(): array
    {
        return [
            'unread_count' => 0,
            'recent_count' => 0,
            'critical_count' => 0,
            'reminder_count' => 0,
            'history_count' => 0,
            'active_template_count' => $this->template->newQuery()->where('is_active', true)->count(),
        ];
    }
}
