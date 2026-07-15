<?php

namespace Harvest\Policies;

use Harvest\Models\HarvestQualityControl;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Users\Models\User;

final class HarvestQualityControlPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view-any-harvest-quality-control');
    }

    public function view(User $user, HarvestQualityControl $harvestQualityControl): bool
    {
        return $user->hasPermissionTo('view-harvest-quality-control');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-harvest-quality-control');
    }

    public function update(User $user, HarvestQualityControl $harvestQualityControl): bool
    {
        return $user->hasPermissionTo('update-harvest-quality-control');
    }

    public function delete(User $user, HarvestQualityControl $harvestQualityControl): bool
    {
        return $user->hasPermissionTo('delete-harvest-quality-control');
    }

    public function restore(User $user, HarvestQualityControl $harvestQualityControl): bool
    {
        return $user->hasPermissionTo('restore-harvest-quality-control');
    }

    public function forceDelete(User $user, HarvestQualityControl $harvestQualityControl): bool
    {
        return $user->hasPermissionTo('force-delete-harvest-quality-control');
    }
}