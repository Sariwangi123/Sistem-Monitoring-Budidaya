<?php

namespace Modules\Notifications\Policies;

use Modules\Users\Models\User;

final class NotificationTemplatePolicy
{
    public function manage(User $user): bool
    {
        return $user->hasPermission('notifications.manage');
    }
}
