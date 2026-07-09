<?php

namespace Modules\Auth\Routes;

use Illuminate\Support\Facades\Route;
use Modules\Auth\Controllers\AuthController;

final class AuthRoutes
{
    public static function register(): void
    {
        Route::post('auth/login', [AuthController::class, 'login']);
        Route::post('auth/forgot-password', [AuthController::class, 'forgotPassword']);
        Route::post('auth/reset-password', [AuthController::class, 'resetPassword']);

        Route::middleware('auth:sanctum')->group(function (): void {
            Route::post('auth/logout', [AuthController::class, 'logout']);
            Route::post('auth/refresh-token', [AuthController::class, 'refresh']);
            Route::post('auth/change-password', [AuthController::class, 'changePassword']);
        });
    }
}
