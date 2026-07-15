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
            Route::get('/', [NotificationController::class, 'index']);
            Route::patch('read-all', [NotificationController::class, 'readAll']);
            Route::patch('archive-all', [NotificationController::class, 'archiveAll']);
            Route::get('preferences', [NotificationController::class, 'preferences']);
            Route::put('preferences', [NotificationController::class, 'updatePreferences']);
            Route::get('history', [NotificationController::class, 'history']);
            Route::get('search', [NotificationController::class, 'search']);
            Route::get('statistics', [NotificationController::class, 'statistics']);
            Route::get('registry', [NotificationController::class, 'registry']);
            Route::get('templates', [NotificationController::class, 'templates']);
            Route::get('export', [NotificationController::class, 'export']);
            Route::get('{notification}', [NotificationController::class, 'show']);
            Route::patch('{notification}/read', [NotificationController::class, 'read']);
            Route::patch('{notification}/archive', [NotificationController::class, 'archive']);
            Route::post('{notification}/retry', [NotificationController::class, 'retry']);
            Route::delete('{notification}', [NotificationController::class, 'destroy']);
        });

        Route::apiResource('notification-templates', NotificationTemplateController::class)
            ->middleware('permission:notifications.manage');
    }
}
