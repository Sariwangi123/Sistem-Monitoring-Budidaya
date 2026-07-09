<?php

namespace Modules\Settings\Routes;

use Illuminate\Support\Facades\Route;
use Modules\Settings\Controllers\GlobalSettingController;

final class SettingRoutes
{
    public static function register(): void
    {
        Route::apiResource('settings', GlobalSettingController::class)->middleware('permission:settings.manage');
    }
}
