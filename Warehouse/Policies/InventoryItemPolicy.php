<?php

namespace Warehouse\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Users\Models\User;
use Warehouse\Models\InventoryItem;

final class InventoryItemPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view-any-inventory-item');
    }

    public function view(User $user, InventoryItem $inventoryItem): bool
    {
        return $user->hasPermissionTo('view-inventory-item');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-inventory-item');
    }

    public function update(User $user, InventoryItem $inventoryItem): bool
    {
        return $user->hasPermissionTo('update-inventory-item');
    }

    public function delete(User $user, InventoryItem $inventoryItem): bool
    {
        return $user->hasPermissionTo('delete-inventory-item');
    }

    public function restore(User $user, InventoryItem $inventoryItem): bool
    {
        return $user->hasPermissionTo('restore-inventory-item');
    }

    public function forceDelete(User $user, InventoryItem $inventoryItem): bool
    {
        return $user->hasPermissionTo('force-delete-inventory-item');
    }
}
