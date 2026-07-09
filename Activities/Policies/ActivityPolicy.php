<?php

namespace Activities\Policies;

use Modules\Users\Models\User;
use Activities\Models\Activity;
use Illuminate\Auth\Access\HandlesAuthorization;

final class ActivityPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view-any-activity');
    }

    public function view(User $user, Activity $activity): bool
    {
        return $user->hasPermissionTo('view-activity');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-activity');
    }

    public function update(User $user, Activity $activity): bool
    {
        return $user->hasPermissionTo('update-activity');
    }

    public function delete(User $user, Activity $activity): bool
    {
        return $user->hasPermissionTo('delete-activity');
    }

    public function restore(User $user, Activity $activity): bool
    {
        return $user->hasPermissionTo('restore-activity');
    }

    public function forceDelete(User $user, Activity $activity): bool
    {
        return $user->hasPermissionTo('force-delete-activity');
    }
}