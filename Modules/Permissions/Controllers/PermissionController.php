<?php

namespace Modules\Permissions\Controllers;

use Core\DTO\PaginationQuery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Permissions\Requests\StorePermissionRequest;
use Modules\Permissions\Requests\UpdatePermissionRequest;
use Modules\Permissions\Services\PermissionService;
use Shared\Http\ApiResponse;

final class PermissionController
{
    public function __construct(private readonly PermissionService $permissions)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $query = PaginationQuery::fromArray($request->query());

        return ApiResponse::success('Permissions retrieved.', $this->permissions->list($request->query(), $query->perPage));
    }

    public function store(StorePermissionRequest $request): JsonResponse
    {
        return ApiResponse::success('Permission created.', $this->permissions->store($request->validated()), 201);
    }

    public function show(string $permission): JsonResponse
    {
        return ApiResponse::success('Permission retrieved.', $this->permissions->detail($permission));
    }

    public function update(UpdatePermissionRequest $request, string $permission): JsonResponse
    {
        return ApiResponse::success('Permission updated.', $this->permissions->change($permission, $request->validated()));
    }

    public function destroy(string $permission): JsonResponse
    {
        $this->permissions->remove($permission);

        return ApiResponse::success('Permission deleted.');
    }
}
