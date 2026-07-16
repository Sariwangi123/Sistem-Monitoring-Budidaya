<?php

namespace Modules\Administration\Repositories;

use Modules\Administration\Repositories\Contracts\AdministrationRepositoryInterface;
use Modules\Permissions\Models\Permission;
use Modules\Roles\Models\Role;
use Modules\Settings\Models\GlobalSetting;
use Modules\Users\Models\User;

final class AdministrationRepository implements AdministrationRepositoryInterface
{
    public function platformSummary(): array
    {
        return [
            'users' => User::query()->count(),
            'active_users' => User::query()->where('is_active', true)->count(),
            'roles' => Role::query()->count(),
            'permissions' => Permission::query()->count(),
            'settings' => GlobalSetting::query()->count(),
        ];
    }

    public function supportedRoles(): array
    {
        return Role::query()->orderBy('name')->get(['name', 'slug'])
            ->map(fn (Role $role): array => ['name' => $role->name, 'slug' => $role->slug])
            ->all();
    }
}
