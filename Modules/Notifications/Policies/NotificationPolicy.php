<?php

namespace Modules\Notifications\Policies;

use Modules\Users\Models\User;

final class NotificationPolicy
{
    /** @var array<int, string> */
    private const ALLOWED_ROLES = [
        'super-admin',
        'farm-owner',
        'director',
        'farm-manager',
        'warehouse-staff',
        'finance-staff',
        'technician',
        'viewer',
    ];

    public function view(User $user): bool
    {
        return $user->roles()
            ->whereIn('slug', self::ALLOWED_ROLES)
            ->exists();
    }
}
