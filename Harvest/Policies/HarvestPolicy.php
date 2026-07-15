<?php

namespace Harvest\Policies;

use Harvest\Models\Harvest;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Users\Models\User;

final class HarvestPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view-any-harvest');
    }

    public function view(User $user, Harvest $harvest): bool
    {
        return $user->hasPermissionTo('view-harvest');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-harvest');
    }

    public function update(User $user, Harvest $harvest): bool
    {
        return $user->hasPermissionTo('update-harvest');
    }

    public function delete(User $user, Harvest $harvest): bool
    {
        return $user->hasPermissionTo('delete-harvest');
    }

    public function restore(User $user, Harvest $harvest): bool
    {
        return $user->hasPermissionTo('restore-harvest');
    }

    public function forceDelete(User $user, Harvest $harvest): bool
    {
        return $user->hasPermissionTo('force-delete-harvest');
    }
}