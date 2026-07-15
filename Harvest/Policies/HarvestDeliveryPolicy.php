<?php

namespace Harvest\Policies;

use Harvest\Models\HarvestDelivery;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Users\Models\User;

final class HarvestDeliveryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view-any-harvest-delivery');
    }

    public function view(User $user, HarvestDelivery $harvestDelivery): bool
    {
        return $user->hasPermissionTo('view-harvest-delivery');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-harvest-delivery');
    }

    public function update(User $user, HarvestDelivery $harvestDelivery): bool
    {
        return $user->hasPermissionTo('update-harvest-delivery');
    }

    public function delete(User $user, HarvestDelivery $harvestDelivery): bool
    {
        return $user->hasPermissionTo('delete-harvest-delivery');
    }

    public function restore(User $user, HarvestDelivery $harvestDelivery): bool
    {
        return $user->hasPermissionTo('restore-harvest-delivery');
    }

    public function forceDelete(User $user, HarvestDelivery $harvestDelivery): bool
    {
        return $user->hasPermissionTo('force-delete-harvest-delivery');
    }
}