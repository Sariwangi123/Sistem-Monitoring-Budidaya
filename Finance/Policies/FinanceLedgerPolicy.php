<?php

namespace Finance\Policies;

use Finance\Models\FinanceLedger;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Users\Models\User;

final class FinanceLedgerPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $this->can($user, 'view-any-finance-ledger');
    }

    public function view(User $user, FinanceLedger $financeLedger): bool
    {
        return $this->can($user, 'view-finance-ledger');
    }

    public function create(User $user): bool
    {
        return $this->can($user, 'create-finance-ledger');
    }

    public function update(User $user, FinanceLedger $financeLedger): bool
    {
        return $this->can($user, 'update-finance-ledger');
    }

    public function delete(User $user, FinanceLedger $financeLedger): bool
    {
        return $this->can($user, 'delete-finance-ledger');
    }

    public function restore(User $user, FinanceLedger $financeLedger): bool
    {
        return $this->can($user, 'restore-finance-ledger');
    }

    public function forceDelete(User $user, FinanceLedger $financeLedger): bool
    {
        return $this->can($user, 'force-delete-finance-ledger');
    }

    private function can(User $user, string $permission): bool
    {
        return method_exists($user, 'hasPermissionTo')
            ? $user->hasPermissionTo($permission)
            : $user->hasPermission($permission);
    }
}
