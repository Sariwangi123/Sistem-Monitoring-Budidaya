<?php

namespace Dashboard\Routes;

use Dashboard\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

final class DashboardRoutes
{
    public static function register(): void
    {
        Route::prefix('dashboard')->group(function (): void {
            Route::get('/', [DashboardController::class, 'index']);
            Route::get('workspace', [DashboardController::class, 'workspace']);
        });
    }
}
