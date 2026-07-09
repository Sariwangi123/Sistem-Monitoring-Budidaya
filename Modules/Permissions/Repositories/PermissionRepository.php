<?php

namespace Modules\Permissions\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Infrastructure\Persistence\EloquentRepository;
use Modules\Permissions\Models\Permission;

final class PermissionRepository extends EloquentRepository
{
    public function __construct(Permission $permission)
    {
        parent::__construct($permission);
    }

    protected function applySearch(Builder $query, string $search): void
    {
        $query->where('name', 'like', "%{$search}%")
            ->orWhere('slug', 'like', "%{$search}%");
    }
}
