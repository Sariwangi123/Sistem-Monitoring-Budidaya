<?php

namespace Finance\Policies;

use Finance\Models\FinanceProfitCalculation;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Users\Models\User;

final class FinanceProfitCalculationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $this->can($user, 'view-any-finance-profit-calculation');
    }

    public function view(User $user, FinanceProfitCalculation $financeProfitCalculation): bool
    {
        return $this->can($user, 'view-finance-profit-calculation');
    }

    public function create(User $user): bool
    {
        return $this->can($user, 'create-finance-profit-calculation');
    }

    public function update(User $user, FinanceProfitCalculation $financeProfitCalculation): bool
    {
        return $this->can($user, 'update-finance-profit-calculation');
    }

    public function delete(User $user, FinanceProfitCalculation $financeProfitCalculation): bool
    {
        return $this->can($user, 'delete-finance-profit-calculation');
    }

    public function restore(User $user, FinanceProfitCalculation $financeProfitCalculation): bool
    {
        return $this->can($user, 'restore-finance-profit-calculation');
    }

    public function forceDelete(User $user, FinanceProfitCalculation $financeProfitCalculation): bool
    {
        return $this->can($user, 'force-delete-finance-profit-calculation');
    }

    private function can(User $user, string $permission): bool
    {
        return method_exists($user, 'hasPermissionTo')
            ? $user->hasPermissionTo($permission)
            : $user->hasPermission($permission);
    }
}
