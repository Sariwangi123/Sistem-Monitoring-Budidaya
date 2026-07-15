<?php

namespace Harvest\Routes;

use Harvest\Http\Controllers\HarvestBatchController;
use Harvest\Http\Controllers\HarvestController;
use Harvest\Http\Controllers\HarvestDeliveryController;
use Harvest\Http\Controllers\HarvestGradeController;
use Harvest\Http\Controllers\HarvestPackingController;
use Harvest\Http\Controllers\HarvestQualityControlController;
use Illuminate\Support\Facades\Route;

final class HarvestRoutes
{
    public static function register(): void
    {
        Route::apiResource('harvest', HarvestController::class);
        Route::post('harvest/{harvest}/restore', [HarvestController::class, 'restore']);
        Route::delete('harvest/{harvest}/force', [HarvestController::class, 'forceDelete']);

        Route::prefix('harvest')->group(function (): void {
            Route::apiResource('batches', HarvestBatchController::class);
            Route::post('batches/{batch}/restore', [HarvestBatchController::class, 'restore']);
            Route::delete('batches/{batch}/force', [HarvestBatchController::class, 'forceDelete']);

            Route::apiResource('deliveries', HarvestDeliveryController::class);
            Route::post('deliveries/{delivery}/restore', [HarvestDeliveryController::class, 'restore']);
            Route::delete('deliveries/{delivery}/force', [HarvestDeliveryController::class, 'forceDelete']);

            Route::apiResource('grades', HarvestGradeController::class);
            Route::post('grades/{grade}/restore', [HarvestGradeController::class, 'restore']);
            Route::delete('grades/{grade}/force', [HarvestGradeController::class, 'forceDelete']);

            Route::apiResource('packings', HarvestPackingController::class);
            Route::post('packings/{packing}/restore', [HarvestPackingController::class, 'restore']);
            Route::delete('packings/{packing}/force', [HarvestPackingController::class, 'forceDelete']);

            Route::apiResource('quality-controls', HarvestQualityControlController::class);
            Route::post('quality-controls/{quality_control}/restore', [HarvestQualityControlController::class, 'restore']);
            Route::delete('quality-controls/{quality_control}/force', [HarvestQualityControlController::class, 'forceDelete']);
        });
    }
}
