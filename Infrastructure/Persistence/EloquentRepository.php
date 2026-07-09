<?php

namespace Infrastructure\Persistence;

use Core\Contracts\RepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class EloquentRepository implements RepositoryInterface
{
    public function __construct(protected Model $model)
    {
    }

    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->query($filters)->paginate($perPage);
    }

    public function all(array $filters = []): Collection
    {
        return $this->query($filters)->get();
    }

    public function find(string $id): ?Model
    {
        return $this->model->newQuery()->whereKey($id)->first();
    }

    public function create(array $payload): Model
    {
        return $this->model->newQuery()->create($payload);
    }

    public function update(string $id, array $payload): Model
    {
        $model = $this->model->newQuery()->whereKey($id)->firstOrFail();
        $model->update($payload);

        return $model->refresh();
    }

    public function delete(string $id): void
    {
        $this->model->newQuery()->whereKey($id)->firstOrFail()->delete();
    }

    protected function query(array $filters = []): Builder
    {
        $query = $this->model->newQuery();

        if (! empty($filters['search'])) {
            $this->applySearch($query, (string) $filters['search']);
        }

        if (! empty($filters['sort'])) {
            $direction = $filters['direction'] ?? 'asc';
            $query->orderBy((string) $filters['sort'], $direction === 'desc' ? 'desc' : 'asc');
        }

        return $query;
    }

    protected function applySearch(Builder $query, string $search): void
    {
        //
    }
}
