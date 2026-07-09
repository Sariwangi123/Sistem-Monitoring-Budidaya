<?php

namespace CultureCycle\Policies;

use Modules\Auth\Models\User;
use CultureCycle\Models\CultureCycle;
use Illuminate\Auth\Access\HandlesAuthorization;

class CultureCyclePolicy
{
    use HandlesAuthorization;

    public function before(User $user): ?bool
    {
        return $user->is_superadmin ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $user->can('culture-cycle.view');
    }

    public function view(User $user, CultureCycle $cultureCycle): bool
    {
        return $user->company_id === $cultureCycle->company_id
            && $user->can('culture-cycle.view');
    }

    public function create(User $user): bool
    {
        return $user->can('culture-cycle.create');
    }

    public function update(User $user, CultureCycle $cultureCycle): bool
    {
        return $user->company_id === $cultureCycle->company_id
            && $user->can('culture-cycle.update');
    }

    public function delete(User $user, CultureCycle $cultureCycle): bool
    {
        return $user->company_id === $cultureCycle->company_id
            && $user->can('culture-cycle.delete');
    }

    public function restore(User $user, CultureCycle $cultureCycle): bool
    {
        return $user->company_id === $cultureCycle->company_id
            && $user->can('culture-cycle.restore');
    }

    public function forceDelete(User $user, CultureCycle $cultureCycle): bool
    {
        return $user->company_id === $cultureCycle->company_id
            && $user->can('culture-cycle.force-delete');
    }
}