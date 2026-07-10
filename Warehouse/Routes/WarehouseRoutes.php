<?php

namespace Warehouse\Routes;

use Illuminate\Support\Facades\Route;
use Warehouse\Http\Controllers\InventoryBatchController;
use Warehouse\Http\Controllers\InventoryItemController;
use Warehouse\Http\Controllers\InventoryMovementController;
use Warehouse\Http\Controllers\InventoryStockController;
use Warehouse\Http\Controllers\StockOpnameController;
use Warehouse\Http\Controllers\StockOpnameDetailController;
use Warehouse\Http\Controllers\WarehouseController;
use Warehouse\Http\Controllers\WarehouseLocationController;

final class WarehouseRoutes
{
    public static function register(): void
    {
        Route::prefix('warehouse')->group(function (): void {
            Route::apiResource('warehouses', WarehouseController::class);
            Route::post('warehouses/{warehouse}/restore', [WarehouseController::class, 'restore']);
            Route::delete('warehouses/{warehouse}/force', [WarehouseController::class, 'forceDelete']);

            Route::apiResource('locations', WarehouseLocationController::class);
            Route::post('locations/{location}/restore', [WarehouseLocationController::class, 'restore']);
            Route::delete('locations/{location}/force', [WarehouseLocationController::class, 'forceDelete']);

            Route::apiResource('inventory-items', InventoryItemController::class);
            Route::post('inventory-items/{inventory_item}/restore', [InventoryItemController::class, 'restore']);
            Route::delete('inventory-items/{inventory_item}/force', [InventoryItemController::class, 'forceDelete']);

            Route::apiResource('inventory-batches', InventoryBatchController::class);
            Route::post('inventory-batches/{inventory_batch}/restore', [InventoryBatchController::class, 'restore']);
            Route::delete('inventory-batches/{inventory_batch}/force', [InventoryBatchController::class, 'forceDelete']);

            Route::apiResource('inventory-movements', InventoryMovementController::class);
            Route::post('inventory-movements/{inventory_movement}/restore', [InventoryMovementController::class, 'restore']);
            Route::delete('inventory-movements/{inventory_movement}/force', [InventoryMovementController::class, 'forceDelete']);

            Route::apiResource('inventory-stocks', InventoryStockController::class);
            Route::post('inventory-stocks/{inventory_stock}/restore', [InventoryStockController::class, 'restore']);
            Route::delete('inventory-stocks/{inventory_stock}/force', [InventoryStockController::class, 'forceDelete']);

            Route::apiResource('stock-opnames', StockOpnameController::class);
            Route::post('stock-opnames/{stock_opname}/restore', [StockOpnameController::class, 'restore']);
            Route::delete('stock-opnames/{stock_opname}/force', [StockOpnameController::class, 'forceDelete']);

            Route::apiResource('stock-opname-details', StockOpnameDetailController::class);
            Route::post('stock-opname-details/{stock_opname_detail}/restore', [StockOpnameDetailController::class, 'restore']);
            Route::delete('stock-opname-details/{stock_opname_detail}/force', [StockOpnameDetailController::class, 'forceDelete']);
        });
    }
}
