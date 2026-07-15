<?php

namespace Finance\Policies;

use Finance\Models\FinanceExpense;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Users\Models\User;

final class FinanceExpensePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $this->can($user, 'view-any-finance-expense');
    }

    public function view(User $user, FinanceExpense $financeExpense): bool
    {
        return $this->can($user, 'view-finance-expense');
    }

    public function create(User $user): bool
    {
        return $this->can($user, 'create-finance-expense');
    }

    public function update(User $user, FinanceExpense $financeExpense): bool
    {
        return $this->can($user, 'update-finance-expense');
    }

    public function delete(User $user, FinanceExpense $financeExpense): bool
    {
        return $this->can($user, 'delete-finance-expense');
    }

    public function restore(User $user, FinanceExpense $financeExpense): bool
    {
        return $this->can($user, 'restore-finance-expense');
    }

    public function forceDelete(User $user, FinanceExpense $financeExpense): bool
    {
        return $this->can($user, 'force-delete-finance-expense');
    }

    private function can(User $user, string $permission): bool
    {
        return method_exists($user, 'hasPermissionTo')
            ? $user->hasPermissionTo($permission)
            : $user->hasPermission($permission);
    }
}
