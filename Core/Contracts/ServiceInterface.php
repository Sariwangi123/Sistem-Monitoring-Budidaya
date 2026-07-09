<?php

namespace Core\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

interface ServiceInterface
{
    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function detail(string $id): Model;

    public function store(array $payload): Model;

    public function change(string $id, array $payload): Model;

    public function remove(string $id): void;
}
