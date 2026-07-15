<?php

namespace Harvest\Policies;

use Harvest\Models\HarvestBatch;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Users\Models\User;

final class HarvestBatchPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view-any-harvest-batch');
    }

    public function view(User $user, HarvestBatch $harvestBatch): bool
    {
        return $user->hasPermissionTo('view-harvest-batch');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-harvest-batch');
    }

    public function update(User $user, HarvestBatch $harvestBatch): bool
    {
        return $user->hasPermissionTo('update-harvest-batch');
    }

    public function delete(User $user, HarvestBatch $harvestBatch): bool
    {
        return $user->hasPermissionTo('delete-harvest-batch');
    }

    public function restore(User $user, HarvestBatch $harvestBatch): bool
    {
        return $user->hasPermissionTo('restore-harvest-batch');
    }

    public function forceDelete(User $user, HarvestBatch $harvestBatch): bool
    {
        return $user->hasPermissionTo('force-delete-harvest-batch');
    }
}