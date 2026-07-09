<?php

namespace Modules\Users\Routes;

use Illuminate\Support\Facades\Route;
use Modules\Permissions\Controllers\PermissionController;
use Modules\Roles\Controllers\RoleController;
use Modules\Users\Controllers\UserController;

final class UserRoutes
{
    public static function register(): void
    {
        Route::apiResource('users', UserController::class)->middleware('permission:users.manage');
        Route::post('users/{user}/roles', [UserController::class, 'assignRoles'])->middleware('permission:users.manage');
        Route::apiResource('roles', RoleController::class)->middleware('permission:roles.manage');
        Route::post('roles/{role}/permissions', [RoleController::class, 'assignPermissions'])
            ->middleware('permission:roles.manage');
        Route::apiResource('permissions', PermissionController::class)->middleware('permission:permissions.manage');
    }
}
