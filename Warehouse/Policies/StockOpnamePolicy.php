<?php

namespace Warehouse\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Users\Models\User;
use Warehouse\Models\StockOpname;

final class StockOpnamePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view-any-stock-opname');
    }

    public function view(User $user, StockOpname $stockOpname): bool
    {
        return $user->hasPermissionTo('view-stock-opname');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-stock-opname');
    }

    public function update(User $user, StockOpname $stockOpname): bool
    {
        return $user->hasPermissionTo('update-stock-opname');
    }

    public function delete(User $user, StockOpname $stockOpname): bool
    {
        return $user->hasPermissionTo('delete-stock-opname');
    }

    public function restore(User $user, StockOpname $stockOpname): bool
    {
        return $user->hasPermissionTo('restore-stock-opname');
    }

    public function forceDelete(User $user, StockOpname $stockOpname): bool
    {
        return $user->hasPermissionTo('force-delete-stock-opname');
    }
}
