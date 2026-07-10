<?php

namespace Warehouse\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Users\Models\User;
use Warehouse\Models\InventoryMovement;

final class InventoryMovementPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view-any-inventory-movement');
    }

    public function view(User $user, InventoryMovement $inventoryMovement): bool
    {
        return $user->hasPermissionTo('view-inventory-movement');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-inventory-movement');
    }

    public function update(User $user, InventoryMovement $inventoryMovement): bool
    {
        return $user->hasPermissionTo('update-inventory-movement');
    }

    public function delete(User $user, InventoryMovement $inventoryMovement): bool
    {
        return $user->hasPermissionTo('delete-inventory-movement');
    }

    public function restore(User $user, InventoryMovement $inventoryMovement): bool
    {
        return $user->hasPermissionTo('restore-inventory-movement');
    }

    public function forceDelete(User $user, InventoryMovement $inventoryMovement): bool
    {
        return $user->hasPermissionTo('force-delete-inventory-movement');
    }
}
