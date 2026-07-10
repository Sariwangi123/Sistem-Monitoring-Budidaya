<?php

namespace Warehouse\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Users\Models\User;
use Warehouse\Models\StockOpnameDetail;

final class StockOpnameDetailPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view-any-stock-opname-detail');
    }

    public function view(User $user, StockOpnameDetail $stockOpnameDetail): bool
    {
        return $user->hasPermissionTo('view-stock-opname-detail');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-stock-opname-detail');
    }

    public function update(User $user, StockOpnameDetail $stockOpnameDetail): bool
    {
        return $user->hasPermissionTo('update-stock-opname-detail');
    }

    public function delete(User $user, StockOpnameDetail $stockOpnameDetail): bool
    {
        return $user->hasPermissionTo('delete-stock-opname-detail');
    }

    public function restore(User $user, StockOpnameDetail $stockOpnameDetail): bool
    {
        return $user->hasPermissionTo('restore-stock-opname-detail');
    }

    public function forceDelete(User $user, StockOpnameDetail $stockOpnameDetail): bool
    {
        return $user->hasPermissionTo('force-delete-stock-opname-detail');
    }
}
