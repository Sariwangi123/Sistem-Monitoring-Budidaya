<?php

namespace MasterData\Routes;

use Illuminate\Support\Facades\Route;
use MasterData\Http\Controllers\ProvinceController;
use MasterData\Http\Controllers\CityController;
use MasterData\Http\Controllers\DistrictController;
use MasterData\Http\Controllers\VillageController;
use MasterData\Http\Controllers\UnitController;
use MasterData\Http\Controllers\CompanyController;
use MasterData\Http\Controllers\FarmController;
use MasterData\Http\Controllers\PondAreaController;
use MasterData\Http\Controllers\PondController;
use MasterData\Http\Controllers\FishSpeciesController;
use MasterData\Http\Controllers\FishStrainController;
use MasterData\Http\Controllers\FeedBrandController;
use MasterData\Http\Controllers\FeedCategoryController;
use MasterData\Http\Controllers\FeedTypeController;
use MasterData\Http\Controllers\MedicineController;
use MasterData\Http\Controllers\ProbioticController;
use MasterData\Http\Controllers\VitaminController;
use MasterData\Http\Controllers\SupplierController;
use MasterData\Http\Controllers\CustomerController;
use MasterData\Http\Controllers\EmployeeController;
use MasterData\Http\Controllers\GeneralReferenceController;

class MasterDataRoutes
{
    public static function register(): void
    {
        Route::prefix('master')->group(function (): void {
            // Wilayah
            Route::apiResource('provinces', ProvinceController::class);
            Route::apiResource('cities', CityController::class);
            Route::apiResource('districts', DistrictController::class);
            Route::apiResource('villages', VillageController::class);

            // Unit & Perusahaan
            Route::apiResource('units', UnitController::class);
            Route::apiResource('companies', CompanyController::class);

            // Farm & Kolam
            Route::apiResource('farms', FarmController::class);
            Route::apiResource('pond-areas', PondAreaController::class);
            Route::apiResource('ponds', PondController::class);

            // Ikan
            Route::apiResource('fish-species', FishSpeciesController::class);
            Route::apiResource('fish-strains', FishStrainController::class);

            // Pakan
            Route::apiResource('feed-brands', FeedBrandController::class);
            Route::apiResource('feed-categories', FeedCategoryController::class);
            Route::apiResource('feed-types', FeedTypeController::class);

            // Obat & Suplemen
            Route::apiResource('medicines', MedicineController::class);
            Route::apiResource('probiotics', ProbioticController::class);
            Route::apiResource('vitamins', VitaminController::class);

            // Supplier & Customer & Karyawan
            Route::apiResource('suppliers', SupplierController::class);
            Route::apiResource('customers', CustomerController::class);
            Route::apiResource('employees', EmployeeController::class);

            // Referensi umum
            Route::apiResource('general-references', GeneralReferenceController::class);
        });
    }
}