<?php

namespace Modules\Administration\Policies;

use Modules\Users\Models\User;

final class AdministrationPolicy
{
    public function view(User $user): bool
    {
        return $user->hasPermission('users.manage') || $user->hasPermission('roles.manage')
            || $user->hasPermission('permissions.manage') || $user->hasPermission('settings.manage')
            || $user->roles()->whereIn('slug', ['super-admin', 'administrator'])->exists();
    }
}
