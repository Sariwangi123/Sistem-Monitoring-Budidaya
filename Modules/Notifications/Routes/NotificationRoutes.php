<?php

namespace Modules\Notifications\Routes;

use Illuminate\Support\Facades\Route;
use Modules\Notifications\Controllers\NotificationTemplateController;

final class NotificationRoutes
{
    public static function register(): void
    {
        Route::apiResource('notification-templates', NotificationTemplateController::class)
            ->middleware('permission:notifications.manage');
    }
}
