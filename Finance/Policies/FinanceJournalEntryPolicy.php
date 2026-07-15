<?php

namespace Finance\Policies;

use Finance\Models\FinanceJournalEntry;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Users\Models\User;

final class FinanceJournalEntryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $this->can($user, 'view-any-finance-journal-entry');
    }

    public function view(User $user, FinanceJournalEntry $financeJournalEntry): bool
    {
        return $this->can($user, 'view-finance-journal-entry');
    }

    public function create(User $user): bool
    {
        return $this->can($user, 'create-finance-journal-entry');
    }

    public function update(User $user, FinanceJournalEntry $financeJournalEntry): bool
    {
        return $this->can($user, 'update-finance-journal-entry');
    }

    public function delete(User $user, FinanceJournalEntry $financeJournalEntry): bool
    {
        return $this->can($user, 'delete-finance-journal-entry');
    }

    public function restore(User $user, FinanceJournalEntry $financeJournalEntry): bool
    {
        return $this->can($user, 'restore-finance-journal-entry');
    }

    public function forceDelete(User $user, FinanceJournalEntry $financeJournalEntry): bool
    {
        return $this->can($user, 'force-delete-finance-journal-entry');
    }

    private function can(User $user, string $permission): bool
    {
        return method_exists($user, 'hasPermissionTo')
            ? $user->hasPermissionTo($permission)
            : $user->hasPermission($permission);
    }
}
