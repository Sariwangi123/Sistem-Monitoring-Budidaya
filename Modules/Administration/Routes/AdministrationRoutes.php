<?php

namespace Modules\Administration\Routes;

use Illuminate\Support\Facades\Route;
use Modules\Administration\Controllers\AdministrationController;

final class AdministrationRoutes
{
    public static function register(): void
    {
        Route::prefix('admin')->group(function (): void {
            Route::get('overview', [AdministrationController::class, 'overview']);
            Route::get('configurations', [AdministrationController::class, 'configurations']);
            Route::get('configurations/{key}', [AdministrationController::class, 'configuration']);
            Route::put('configurations/{key}', [AdministrationController::class, 'updateConfiguration']);
            Route::get('modules', [AdministrationController::class, 'modules']);
            Route::get('modules/{module}', [AdministrationController::class, 'module']);
            Route::get('features', [AdministrationController::class, 'features']);
            Route::put('features/{feature}', [AdministrationController::class, 'updateFeature']);
            Route::get('health', [AdministrationController::class, 'health']);
            Route::get('health/{check}', [AdministrationController::class, 'healthCheck'])->whereIn('check', ['database', 'cache', 'storage', 'queue']);
            Route::get('security', [AdministrationController::class, 'security']);
            Route::get('security/{section}', [AdministrationController::class, 'securitySection'])->whereIn('section', ['permissions', 'roles']);
            Route::get('monitoring', [AdministrationController::class, 'monitoring']);
            Route::get('monitoring/{check}', [AdministrationController::class, 'monitoringCheck'])->whereIn('check', ['application', 'cache', 'database', 'queue']);
            Route::get('audit', [AdministrationController::class, 'audit']);
            Route::get('audit/statistics', [AdministrationController::class, 'auditStatistics']);
            Route::get('backup', [AdministrationController::class, 'backup']);
            Route::get('backup/history', [AdministrationController::class, 'backupHistory']);
            Route::get('integration', [AdministrationController::class, 'integration']);
        });
    }
}
