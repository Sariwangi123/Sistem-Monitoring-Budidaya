<?php

namespace Core\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface RepositoryInterface
{
    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function all(array $filters = []): Collection;

    public function find(int|string $id): ?Model;

    public function create(array $payload): Model;

    public function update(int|string $id, array $payload): Model;

    public function delete(int|string $id): bool;
}
