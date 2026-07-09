<?php

namespace CultureCycle\Routes;

use Illuminate\Support\Facades\Route;
use CultureCycle\Http\Controllers\CultureCycleController;

class CultureCycleRoutes
{
    public static function register(): void
    {
        Route::prefix('culture')->group(function (): void {
            Route::apiResource('cycles', CultureCycleController::class);
        });
    }
}