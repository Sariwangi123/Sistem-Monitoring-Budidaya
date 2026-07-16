<?php

namespace Modules\Administration\Policies;

use Modules\Users\Models\User;

final class AdministrationPolicy
{
    public function view(User $user): bool
    {
        return $user->roles()->whereIn('slug', ['super-admin', 'administrator'])->exists();
    }
}
