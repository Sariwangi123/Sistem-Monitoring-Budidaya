<?php

namespace Finance\Policies;

use Finance\Models\FinanceCostAllocation;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Users\Models\User;

final class FinanceCostAllocationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $this->can($user, 'view-any-finance-cost-allocation');
    }

    public function view(User $user, FinanceCostAllocation $financeCostAllocation): bool
    {
        return $this->can($user, 'view-finance-cost-allocation');
    }

    public function create(User $user): bool
    {
        return $this->can($user, 'create-finance-cost-allocation');
    }

    public function update(User $user, FinanceCostAllocation $financeCostAllocation): bool
    {
        return $this->can($user, 'update-finance-cost-allocation');
    }

    public function delete(User $user, FinanceCostAllocation $financeCostAllocation): bool
    {
        return $this->can($user, 'delete-finance-cost-allocation');
    }

    public function restore(User $user, FinanceCostAllocation $financeCostAllocation): bool
    {
        return $this->can($user, 'restore-finance-cost-allocation');
    }

    public function forceDelete(User $user, FinanceCostAllocation $financeCostAllocation): bool
    {
        return $this->can($user, 'force-delete-finance-cost-allocation');
    }

    private function can(User $user, string $permission): bool
    {
        return method_exists($user, 'hasPermissionTo')
            ? $user->hasPermissionTo($permission)
            : $user->hasPermission($permission);
    }
}
