<?php

namespace MasterData\Services;

use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use MasterData\Repositories\BaseRepository;

abstract class BaseService
{
    protected BaseRepository $repository;

    public function __construct(BaseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findById(int|string $id): ?object
    {
        return $this->repository->findById($id);
    }

    public function findByUuid(string $uuid): ?object
    {
        return $this->repository->findByUuid($uuid);
    }

    public function findTrashedByUuid(string $uuid): ?object
    {
        return $this->repository->findTrashedByUuid($uuid);
    }

    public function getAll(array $columns = ['*']): Collection
    {
        return $this->repository->getAll($columns);
    }

    public function getPaginated(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return $this->repository->getPaginated($perPage, $columns);
    }

    public function create(array $data): object
    {
        return $this->repository->create($data);
    }

    public function update(int|string $id, array $data): object
    {
        return $this->repository->update($id, $data);
    }

    public function delete(int|string $id): bool
    {
        return $this->repository->delete($id);
    }

    public function search(string $search, int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->search($search, $perPage);
    }

    public function getSelectOptions(string $valueColumn = 'name', string $keyColumn = 'id'): Collection
    {
        return $this->repository->getSelectOptions($valueColumn, $keyColumn);
    }
}
