<?php

namespace Warehouse\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Users\Models\User;
use Warehouse\Models\InventoryStock;

final class InventoryStockPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view-any-inventory-stock');
    }

    public function view(User $user, InventoryStock $inventoryStock): bool
    {
        return $user->hasPermissionTo('view-inventory-stock');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-inventory-stock');
    }

    public function update(User $user, InventoryStock $inventoryStock): bool
    {
        return $user->hasPermissionTo('update-inventory-stock');
    }

    public function delete(User $user, InventoryStock $inventoryStock): bool
    {
        return $user->hasPermissionTo('delete-inventory-stock');
    }

    public function restore(User $user, InventoryStock $inventoryStock): bool
    {
        return $user->hasPermissionTo('restore-inventory-stock');
    }

    public function forceDelete(User $user, InventoryStock $inventoryStock): bool
    {
        return $user->hasPermissionTo('force-delete-inventory-stock');
    }
}
