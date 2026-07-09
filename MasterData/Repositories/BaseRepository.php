<?php

namespace MasterData\Repositories;

use Infrastructure\Persistence\EloquentRepository;

abstract class BaseRepository extends EloquentRepository
{
    protected function applySearch(\Illuminate\Database\Eloquent\Builder $query, string $search): void
    {
        $table = $this->model->getTable();
        $columns = \Illuminate\Support\Facades\Schema::getColumnListing($table);

        $query->where(function ($q) use ($search, $columns) {
            foreach ($columns as $index => $column) {
                if (in_array($column, ['id', 'uuid', 'password', 'remember_token', 'created_at', 'updated_at', 'deleted_at'])) {
                    continue;
                }
                if ($index === 0) {
                    $q->where($column, 'like', "%{$search}%");
                } else {
                    $q->orWhere($column, 'like', "%{$search}%");
                }
            }
        });
    }
}