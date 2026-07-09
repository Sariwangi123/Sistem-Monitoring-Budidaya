<?php

namespace Modules\Users\Policies;

use Modules\Users\Models\User;

final class UserPolicy
{
    public function manage(User $user): bool
    {
        return $user->hasPermission('users.manage');
    }
}
