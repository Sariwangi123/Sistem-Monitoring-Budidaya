<?php

namespace Warehouse\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Users\Models\User;
use Warehouse\Models\InventoryBatch;

final class InventoryBatchPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view-any-inventory-batch');
    }

    public function view(User $user, InventoryBatch $inventoryBatch): bool
    {
        return $user->hasPermissionTo('view-inventory-batch');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-inventory-batch');
    }

    public function update(User $user, InventoryBatch $inventoryBatch): bool
    {
        return $user->hasPermissionTo('update-inventory-batch');
    }

    public function delete(User $user, InventoryBatch $inventoryBatch): bool
    {
        return $user->hasPermissionTo('delete-inventory-batch');
    }

    public function restore(User $user, InventoryBatch $inventoryBatch): bool
    {
        return $user->hasPermissionTo('restore-inventory-batch');
    }

    public function forceDelete(User $user, InventoryBatch $inventoryBatch): bool
    {
        return $user->hasPermissionTo('force-delete-inventory-batch');
    }
}
