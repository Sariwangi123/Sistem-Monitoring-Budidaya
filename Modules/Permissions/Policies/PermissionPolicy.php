<?php

namespace Modules\Permissions\Policies;

use Modules\Users\Models\User;

final class PermissionPolicy
{
    public function manage(User $user): bool
    {
        return $user->hasPermission('permissions.manage');
    }
}
