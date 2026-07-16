<?php

namespace Modules\Administration\Routes;

use Illuminate\Support\Facades\Route;
use Modules\Administration\Controllers\AdministrationController;

final class AdministrationRoutes
{
    public static function register(): void
    {
        Route::prefix('admin')->group(function (): void {
            Route::get('overview', [AdministrationController::class, 'overview']);
        });
    }
}
