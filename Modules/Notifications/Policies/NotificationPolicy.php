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

    public function updateStatus(User $user): bool
    {
        return $this->view($user);
    }

    public function delete(User $user): bool
    {
        return $this->view($user);
    }

    public function updatePreferences(User $user): bool
    {
        return $this->view($user);
    }

    public function retry(User $user): bool
    {
        return $user->hasPermission('notifications.retry')
            || $user->roles()->whereIn('slug', ['super-admin', 'farm-manager'])->exists();
    }

    public function manageRegistry(User $user): bool
    {
        return $user->roles()->where('slug', 'super-admin')->exists();
    }
}
