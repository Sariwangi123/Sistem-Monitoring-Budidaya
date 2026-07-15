<?php

namespace Dashboard\Routes;

use Dashboard\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

final class DashboardRoutes
{
    public static function register(): void
    {
        Route::prefix('dashboard')->group(function (): void {
            Route::get('/', [DashboardController::class, 'index']);
            Route::get('snapshot', [DashboardController::class, 'snapshot']);
            Route::get('workspace', [DashboardController::class, 'workspace']);
            Route::get('executive', [DashboardController::class, 'workspaceByKey'])->defaults('workspace', 'executive');
            Route::get('production', [DashboardController::class, 'workspaceByKey'])->defaults('workspace', 'production');
            Route::get('inventory', [DashboardController::class, 'workspaceByKey'])->defaults('workspace', 'inventory');
            Route::get('harvest', [DashboardController::class, 'workspaceByKey'])->defaults('workspace', 'harvest');
            Route::get('finance', [DashboardController::class, 'workspaceByKey'])->defaults('workspace', 'finance');
            Route::get('system', [DashboardController::class, 'workspaceByKey'])->defaults('workspace', 'system');
            Route::get('kpi', [DashboardController::class, 'kpi']);
            Route::get('widgets', [DashboardController::class, 'widgets']);
            Route::get('widgets/{widget}', [DashboardController::class, 'widgetDetail']);
            Route::post('widgets/{widget}/refresh', [DashboardController::class, 'refreshWidget']);
            Route::get('alerts', [DashboardController::class, 'alerts']);
            Route::get('timeline', [DashboardController::class, 'timeline']);
            Route::get('analytics', [DashboardController::class, 'analytics']);
            Route::get('intelligence', [DashboardController::class, 'intelligence']);
            Route::post('refresh', [DashboardController::class, 'refresh']);
            Route::get('cache/status', [DashboardController::class, 'cacheStatus']);
            Route::delete('cache', [DashboardController::class, 'clearCache']);
            Route::get('export', [DashboardController::class, 'export']);
            Route::get('statistics', [DashboardController::class, 'statistics']);
        });
    }
}
