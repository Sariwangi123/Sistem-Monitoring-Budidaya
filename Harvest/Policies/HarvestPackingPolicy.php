<?php

namespace Harvest\Policies;

use Harvest\Models\HarvestPacking;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Users\Models\User;

final class HarvestPackingPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view-any-harvest-packing');
    }

    public function view(User $user, HarvestPacking $harvestPacking): bool
    {
        return $user->hasPermissionTo('view-harvest-packing');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-harvest-packing');
    }

    public function update(User $user, HarvestPacking $harvestPacking): bool
    {
        return $user->hasPermissionTo('update-harvest-packing');
    }

    public function delete(User $user, HarvestPacking $harvestPacking): bool
    {
        return $user->hasPermissionTo('delete-harvest-packing');
    }

    public function restore(User $user, HarvestPacking $harvestPacking): bool
    {
        return $user->hasPermissionTo('restore-harvest-packing');
    }

    public function forceDelete(User $user, HarvestPacking $harvestPacking): bool
    {
        return $user->hasPermissionTo('force-delete-harvest-packing');
    }
}