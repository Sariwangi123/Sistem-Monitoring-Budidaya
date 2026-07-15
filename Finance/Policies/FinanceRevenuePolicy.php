<?php

namespace Finance\Policies;

use Finance\Models\FinanceRevenue;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Users\Models\User;

final class FinanceRevenuePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $this->can($user, 'view-any-finance-revenue');
    }

    public function view(User $user, FinanceRevenue $financeRevenue): bool
    {
        return $this->can($user, 'view-finance-revenue');
    }

    public function create(User $user): bool
    {
        return $this->can($user, 'create-finance-revenue');
    }

    public function update(User $user, FinanceRevenue $financeRevenue): bool
    {
        return $this->can($user, 'update-finance-revenue');
    }

    public function delete(User $user, FinanceRevenue $financeRevenue): bool
    {
        return $this->can($user, 'delete-finance-revenue');
    }

    public function restore(User $user, FinanceRevenue $financeRevenue): bool
    {
        return $this->can($user, 'restore-finance-revenue');
    }

    public function forceDelete(User $user, FinanceRevenue $financeRevenue): bool
    {
        return $this->can($user, 'force-delete-finance-revenue');
    }

    private function can(User $user, string $permission): bool
    {
        return method_exists($user, 'hasPermissionTo')
            ? $user->hasPermissionTo($permission)
            : $user->hasPermission($permission);
    }
}
