<?php

namespace Modules\Roles\Policies;

use Modules\Users\Models\User;

final class RolePolicy
{
    public function manage(User $user): bool
    {
        return $user->hasPermission('roles.manage');
    }
}
