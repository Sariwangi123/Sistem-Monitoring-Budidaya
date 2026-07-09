<?php

namespace MasterData\Policies;

use Modules\Users\Models\User;

final class MasterDataPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('master-data.view');
    }

    public function view(User $user): bool
    {
        return $user->hasPermission('master-data.view');
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('master-data.create');
    }

    public function update(User $user): bool
    {
        return $user->hasPermission('master-data.update');
    }

    public function delete(User $user): bool
    {
        return $user->hasPermission('master-data.delete');
    }

    public function restore(User $user): bool
    {
        return $user->hasPermission('master-data.delete');
    }

    public function forceDelete(User $user): bool
    {
        return $user->hasPermission('master-data.delete');
    }
}