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

    public function find(int|string $id): ?Model
    {
        return $this->model->newQuery()->whereKey($id)->first();
    }

    public function findById(int|string $id): ?Model
    {
        return $this->find($id);
    }

    public function findByUuid(string $uuid): ?Model
    {
        return $this->model->newQuery()->where('uuid', $uuid)->first();
    }

    public function findTrashedByUuid(string $uuid): ?Model
    {
        $query = $this->model->newQuery();

        if (method_exists($this->model, 'bootSoftDeletes')) {
            $query->withTrashed();
        }

        return $query->where('uuid', $uuid)->first();
    }

    public function getAll(array $columns = ['*']): Collection
    {
        return $this->model->newQuery()->get($columns);
    }

    public function getPaginated(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return $this->model->newQuery()->latest()->paginate($perPage, $columns);
    }

    public function create(array $payload): Model
    {
        return $this->model->newQuery()->create($payload);
    }

    public function update(int|string $id, array $payload): Model
    {
        $model = $this->model->newQuery()->whereKey($id)->firstOrFail();
        $model->update($payload);

        return $model->refresh();
    }

    public function delete(int|string $id): bool
    {
        return (bool) $this->model->newQuery()->whereKey($id)->firstOrFail()->delete();
    }

    public function search(string $search, int $perPage = 15): LengthAwarePaginator
    {
        return $this->query(['search' => $search])->paginate($perPage);
    }

    public function getSelectOptions(string $valueColumn = 'name', string $keyColumn = 'id'): Collection
    {
        return $this->model->newQuery()
            ->orderBy($valueColumn)
            ->get([$keyColumn, $valueColumn]);
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
