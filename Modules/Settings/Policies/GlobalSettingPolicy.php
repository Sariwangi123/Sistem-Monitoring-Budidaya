<?php

namespace Modules\Settings\Policies;

use Modules\Users\Models\User;

final class GlobalSettingPolicy
{
    public function manage(User $user): bool
    {
        return $user->hasPermission('settings.manage');
    }
}
