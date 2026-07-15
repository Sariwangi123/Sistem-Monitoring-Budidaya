<?php

namespace ReportAnalytics\Routes;

use Illuminate\Support\Facades\Route;
use ReportAnalytics\Http\Controllers\ReportAnalyticsController;

final class ReportAnalyticsRoutes
{
    public static function register(): void
    {
        Route::prefix('reports')->group(function (): void {
            Route::get('/', [ReportAnalyticsController::class, 'index']);
            Route::get('categories', [ReportAnalyticsController::class, 'categories']);
            Route::get('workspaces', [ReportAnalyticsController::class, 'workspaces']);
        });
    }
}
