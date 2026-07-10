<?php

namespace Warehouse\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Users\Models\User;
use Warehouse\Models\Warehouse;

final class WarehousePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view-any-warehouse');
    }

    public function view(User $user, Warehouse $warehouse): bool
    {
        return $user->hasPermissionTo('view-warehouse');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-warehouse');
    }

    public function update(User $user, Warehouse $warehouse): bool
    {
        return $user->hasPermissionTo('update-warehouse');
    }

    public function delete(User $user, Warehouse $warehouse): bool
    {
        return $user->hasPermissionTo('delete-warehouse');
    }

    public function restore(User $user, Warehouse $warehouse): bool
    {
        return $user->hasPermissionTo('restore-warehouse');
    }

    public function forceDelete(User $user, Warehouse $warehouse): bool
    {
        return $user->hasPermissionTo('force-delete-warehouse');
    }
}
