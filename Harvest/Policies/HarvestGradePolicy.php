<?php

namespace Harvest\Policies;

use Harvest\Models\HarvestGrade;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Users\Models\User;

final class HarvestGradePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view-any-harvest-grade');
    }

    public function view(User $user, HarvestGrade $harvestGrade): bool
    {
        return $user->hasPermissionTo('view-harvest-grade');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-harvest-grade');
    }

    public function update(User $user, HarvestGrade $harvestGrade): bool
    {
        return $user->hasPermissionTo('update-harvest-grade');
    }

    public function delete(User $user, HarvestGrade $harvestGrade): bool
    {
        return $user->hasPermissionTo('delete-harvest-grade');
    }

    public function restore(User $user, HarvestGrade $harvestGrade): bool
    {
        return $user->hasPermissionTo('restore-harvest-grade');
    }

    public function forceDelete(User $user, HarvestGrade $harvestGrade): bool
    {
        return $user->hasPermissionTo('force-delete-harvest-grade');
    }
}