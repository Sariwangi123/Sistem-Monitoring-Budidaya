<?php

namespace Activities\Routes;

use Activities\Http\Controllers\ActivityCategoryController;
use Activities\Http\Controllers\ActivityController;
use Activities\Http\Controllers\ActivityTypeController;
use Illuminate\Support\Facades\Route;

final class ActivitiesRoutes
{
    public static function register(): void
    {
        Route::prefix('activities')->group(function (): void {
            Route::apiResource('categories', ActivityCategoryController::class);
            Route::post('categories/{category}/restore', [ActivityCategoryController::class, 'restore']);
            Route::delete('categories/{category}/force', [ActivityCategoryController::class, 'forceDelete']);

            Route::apiResource('types', ActivityTypeController::class);
            Route::post('types/{type}/restore', [ActivityTypeController::class, 'restore']);
            Route::delete('types/{type}/force', [ActivityTypeController::class, 'forceDelete']);
        });

        Route::apiResource('activities', ActivityController::class);
        Route::post('activities/{activity}/restore', [ActivityController::class, 'restore']);
        Route::delete('activities/{activity}/force', [ActivityController::class, 'forceDelete']);
    }
}
