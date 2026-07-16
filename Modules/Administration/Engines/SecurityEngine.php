<?php

namespace Modules\Administration\Engines;

use Modules\Users\Models\User;

final class SecurityEngine
{
    /** @return array<int, string> */
    public function roles(User $user): array
    {
        return $user->roles()->pluck('slug')->all();
    }

    public function hasPermission(User $user, string $permission): bool
    {
        return $user->hasPermission($permission);
    }

    /** @return array<string, mixed> */
    public function metadata(): array
    {
        return ['authentication' => 'sanctum', 'authorization' => 'existing_rbac_policy_and_gate', 'permission_evaluation' => true, 'role_resolution' => true, 'future_mfa_enabled' => false, 'health' => 'ready'];
    }
}
