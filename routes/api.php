<?php

use CultureCycle\Routes\CultureCycleRoutes;
use Illuminate\Support\Facades\Route;
use MasterData\Routes\MasterDataRoutes;
use Modules\Auth\Routes\AuthRoutes;
use Modules\Notifications\Routes\NotificationRoutes;
use Modules\Settings\Routes\SettingRoutes;
use Modules\Users\Routes\UserRoutes;

Route::prefix('v1')->group(function (): void {
    AuthRoutes::register();

    Route::middleware('auth:sanctum')->group(function (): void {
        MasterDataRoutes::register();
        CultureCycleRoutes::register();
        UserRoutes::register();
        SettingRoutes::register();
        NotificationRoutes::register();
    });
});
