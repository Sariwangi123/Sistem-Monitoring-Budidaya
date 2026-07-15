<?php

use Activities\Routes\ActivitiesRoutes;
use CultureCycle\Routes\CultureCycleRoutes;
use Dashboard\Routes\DashboardRoutes;
use Finance\Routes\FinanceRoutes;
use Harvest\Routes\HarvestRoutes;
use Illuminate\Support\Facades\Route;
use MasterData\Routes\MasterDataRoutes;
use Modules\Auth\Routes\AuthRoutes;
use Modules\Notifications\Routes\NotificationRoutes;
use Modules\Settings\Routes\SettingRoutes;
use Modules\Users\Routes\UserRoutes;
use Warehouse\Routes\WarehouseRoutes;

Route::prefix('v1')->group(function (): void {
    AuthRoutes::register();

    Route::middleware('auth:sanctum')->group(function (): void {
        MasterDataRoutes::register();
        CultureCycleRoutes::register();
        ActivitiesRoutes::register();
        HarvestRoutes::register();
        FinanceRoutes::register();
        WarehouseRoutes::register();
        DashboardRoutes::register();
        UserRoutes::register();
        SettingRoutes::register();
        NotificationRoutes::register();
    });
});
