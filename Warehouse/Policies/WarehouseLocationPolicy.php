<?php

namespace Warehouse\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Users\Models\User;
use Warehouse\Models\WarehouseLocation;

final class WarehouseLocationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view-any-warehouse-location');
    }

    public function view(User $user, WarehouseLocation $warehouseLocation): bool
    {
        return $user->hasPermissionTo('view-warehouse-location');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-warehouse-location');
    }

    public function update(User $user, WarehouseLocation $warehouseLocation): bool
    {
        return $user->hasPermissionTo('update-warehouse-location');
    }

    public function delete(User $user, WarehouseLocation $warehouseLocation): bool
    {
        return $user->hasPermissionTo('delete-warehouse-location');
    }

    public function restore(User $user, WarehouseLocation $warehouseLocation): bool
    {
        return $user->hasPermissionTo('restore-warehouse-location');
    }

    public function forceDelete(User $user, WarehouseLocation $warehouseLocation): bool
    {
        return $user->hasPermissionTo('force-delete-warehouse-location');
    }
}
