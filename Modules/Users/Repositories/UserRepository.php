<?php

namespace Modules\Users\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Infrastructure\Persistence\EloquentRepository;
use Modules\Users\Models\User;

final class UserRepository extends EloquentRepository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    protected function applySearch(Builder $query, string $search): void
    {
        $query->where(function (Builder $builder) use ($search): void {
            $builder->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        });
    }
}
