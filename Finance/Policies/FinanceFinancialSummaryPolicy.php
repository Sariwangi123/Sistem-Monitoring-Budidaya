<?php

namespace Finance\Policies;

use Finance\Models\FinanceFinancialSummary;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Users\Models\User;

final class FinanceFinancialSummaryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $this->can($user, 'view-any-finance-financial-summary');
    }

    public function view(User $user, FinanceFinancialSummary $financeFinancialSummary): bool
    {
        return $this->can($user, 'view-finance-financial-summary');
    }

    public function create(User $user): bool
    {
        return $this->can($user, 'create-finance-financial-summary');
    }

    public function update(User $user, FinanceFinancialSummary $financeFinancialSummary): bool
    {
        return $this->can($user, 'update-finance-financial-summary');
    }

    public function delete(User $user, FinanceFinancialSummary $financeFinancialSummary): bool
    {
        return $this->can($user, 'delete-finance-financial-summary');
    }

    public function restore(User $user, FinanceFinancialSummary $financeFinancialSummary): bool
    {
        return $this->can($user, 'restore-finance-financial-summary');
    }

    public function forceDelete(User $user, FinanceFinancialSummary $financeFinancialSummary): bool
    {
        return $this->can($user, 'force-delete-finance-financial-summary');
    }

    private function can(User $user, string $permission): bool
    {
        return method_exists($user, 'hasPermissionTo')
            ? $user->hasPermissionTo($permission)
            : $user->hasPermission($permission);
    }
}
