<?php

namespace Modules\Roles\Controllers;

use Core\DTO\PaginationQuery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Roles\Requests\AssignPermissionRequest;
use Modules\Roles\Requests\StoreRoleRequest;
use Modules\Roles\Requests\UpdateRoleRequest;
use Modules\Roles\Services\RoleService;
use Shared\Http\ApiResponse;

final class RoleController
{
    public function __construct(private readonly RoleService $roles)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $query = PaginationQuery::fromArray($request->query());

        return ApiResponse::success('Roles retrieved.', $this->roles->list($request->query(), $query->perPage));
    }

    public function store(StoreRoleRequest $request): JsonResponse
    {
        return ApiResponse::success('Role created.', $this->roles->store($request->validated()), 201);
    }

    public function show(string $role): JsonResponse
    {
        return ApiResponse::success('Role retrieved.', $this->roles->detail($role));
    }

    public function update(UpdateRoleRequest $request, string $role): JsonResponse
    {
        return ApiResponse::success('Role updated.', $this->roles->change($role, $request->validated()));
    }

    public function destroy(string $role): JsonResponse
    {
        $this->roles->remove($role);

        return ApiResponse::success('Role deleted.');
    }

    public function assignPermissions(AssignPermissionRequest $request, string $role): JsonResponse
    {
        return ApiResponse::success(
            'Role permissions assigned.',
            $this->roles->assignPermissions($role, $request->validated('permission_ids'))
        );
    }
}
