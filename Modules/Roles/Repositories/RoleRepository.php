<?php

namespace Modules\Roles\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Infrastructure\Persistence\EloquentRepository;
use Modules\Roles\Models\Role;

final class RoleRepository extends EloquentRepository
{
    public function __construct(Role $role)
    {
        parent::__construct($role);
    }

    protected function applySearch(Builder $query, string $search): void
    {
        $query->where('name', 'like', "%{$search}%")
            ->orWhere('slug', 'like', "%{$search}%");
    }
}
