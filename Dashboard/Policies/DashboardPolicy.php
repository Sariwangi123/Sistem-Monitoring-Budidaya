<?php

namespace Dashboard\Policies;

use Modules\Users\Models\User;

final class DashboardPolicy
{
    /** @var array<string, array<int, string>> */
    private const ROLE_WORKSPACES = [
        'super-admin' => ['executive', 'production', 'inventory', 'harvest', 'finance', 'system'],
        'farm-owner' => ['executive', 'production', 'harvest', 'finance'],
        'director' => ['executive', 'production', 'harvest', 'finance'],
        'farm-manager' => ['production', 'harvest', 'inventory'],
        'warehouse-staff' => ['inventory'],
        'finance-staff' => ['finance'],
        'technician' => ['production', 'harvest'],
        'viewer' => ['executive'],
    ];

    public function view(User $user, ?string $workspace = null): bool
    {
        if ($this->hasRole($user, 'super-admin')) {
            return true;
        }

        if ($workspace === null) {
            return $this->allowedWorkspaces($user) !== [];
        }

        return in_array($this->normalizeWorkspace($workspace), $this->allowedWorkspaces($user), true);
    }

    public function clearCache(User $user): bool
    {
        return $this->hasRole($user, 'super-admin');
    }

    /** @return array<int, string> */
    private function allowedWorkspaces(User $user): array
    {
        $roleSlugs = $user->roles()->pluck('slug')->all();
        $workspaces = [];

        foreach ($roleSlugs as $roleSlug) {
            $workspaces = [...$workspaces, ...(self::ROLE_WORKSPACES[$roleSlug] ?? [])];
        }

        return array_values(array_unique($workspaces ?: ['executive']));
    }

    private function hasRole(User $user, string $roleSlug): bool
    {
        return $user->roles()->where('slug', $roleSlug)->exists();
    }

    private function normalizeWorkspace(string $workspace): string
    {
        return $workspace === 'administration' ? 'system' : $workspace;
    }
}
