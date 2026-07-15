<?php

namespace Finance\Policies;

use Finance\Models\FinanceCostCenter;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Users\Models\User;

final class FinanceCostCenterPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $this->can($user, 'view-any-finance-cost-center');
    }

    public function view(User $user, FinanceCostCenter $financeCostCenter): bool
    {
        return $this->can($user, 'view-finance-cost-center');
    }

    public function create(User $user): bool
    {
        return $this->can($user, 'create-finance-cost-center');
    }

    public function update(User $user, FinanceCostCenter $financeCostCenter): bool
    {
        return $this->can($user, 'update-finance-cost-center');
    }

    public function delete(User $user, FinanceCostCenter $financeCostCenter): bool
    {
        return $this->can($user, 'delete-finance-cost-center');
    }

    public function restore(User $user, FinanceCostCenter $financeCostCenter): bool
    {
        return $this->can($user, 'restore-finance-cost-center');
    }

    public function forceDelete(User $user, FinanceCostCenter $financeCostCenter): bool
    {
        return $this->can($user, 'force-delete-finance-cost-center');
    }

    private function can(User $user, string $permission): bool
    {
        return method_exists($user, 'hasPermissionTo')
            ? $user->hasPermissionTo($permission)
            : $user->hasPermission($permission);
    }
}
