<?php

namespace Modules\Notifications\Routes;

use Illuminate\Support\Facades\Route;
use Modules\Notifications\Controllers\NotificationController;
use Modules\Notifications\Controllers\NotificationTemplateController;

final class NotificationRoutes
{
    public static function register(): void
    {
        Route::prefix('notifications')->group(function (): void {
            Route::get('overview', [NotificationController::class, 'overview']);
        });

        Route::apiResource('notification-templates', NotificationTemplateController::class)
            ->middleware('permission:notifications.manage');
    }
}
