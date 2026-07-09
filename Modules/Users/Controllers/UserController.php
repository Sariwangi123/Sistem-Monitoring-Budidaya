<?php

namespace Modules\Users\Controllers;

use Core\DTO\PaginationQuery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Users\Requests\AssignRoleRequest;
use Modules\Users\Requests\StoreUserRequest;
use Modules\Users\Requests\UpdateUserRequest;
use Modules\Users\Services\UserService;
use Shared\Http\ApiResponse;

final class UserController
{
    public function __construct(private readonly UserService $users)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $query = PaginationQuery::fromArray($request->query());

        return ApiResponse::success('Users retrieved.', $this->users->list($request->query(), $query->perPage));
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        return ApiResponse::success('User created.', $this->users->store($request->validated()), 201);
    }

    public function show(string $user): JsonResponse
    {
        return ApiResponse::success('User retrieved.', $this->users->detail($user));
    }

    public function update(UpdateUserRequest $request, string $user): JsonResponse
    {
        return ApiResponse::success('User updated.', $this->users->change($user, $request->validated()));
    }

    public function destroy(string $user): JsonResponse
    {
        $this->users->remove($user);

        return ApiResponse::success('User deleted.');
    }

    public function assignRoles(AssignRoleRequest $request, string $user): JsonResponse
    {
        return ApiResponse::success(
            'User roles assigned.',
            $this->users->assignRoles($user, $request->validated('role_ids'))
        );
    }
}
