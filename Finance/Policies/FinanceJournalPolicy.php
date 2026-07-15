<?php

namespace Finance\Policies;

use Finance\Models\FinanceJournal;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Users\Models\User;

final class FinanceJournalPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $this->can($user, 'view-any-finance-journal');
    }

    public function view(User $user, FinanceJournal $financeJournal): bool
    {
        return $this->can($user, 'view-finance-journal');
    }

    public function create(User $user): bool
    {
        return $this->can($user, 'create-finance-journal');
    }

    public function update(User $user, FinanceJournal $financeJournal): bool
    {
        return $this->can($user, 'update-finance-journal');
    }

    public function delete(User $user, FinanceJournal $financeJournal): bool
    {
        return $this->can($user, 'delete-finance-journal');
    }

    public function restore(User $user, FinanceJournal $financeJournal): bool
    {
        return $this->can($user, 'restore-finance-journal');
    }

    public function forceDelete(User $user, FinanceJournal $financeJournal): bool
    {
        return $this->can($user, 'force-delete-finance-journal');
    }

    private function can(User $user, string $permission): bool
    {
        return method_exists($user, 'hasPermissionTo')
            ? $user->hasPermissionTo($permission)
            : $user->hasPermission($permission);
    }
}
