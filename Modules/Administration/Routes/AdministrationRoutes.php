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
            Route::get('configurations/{key}/versions', [AdministrationController::class, 'configurationVersions']);
            Route::get('configurations/{key}/history', [AdministrationController::class, 'configurationHistory']);
            Route::get('configurations/{key}/publish', [AdministrationController::class, 'configurationPublish']);
            Route::get('configurations/{key}/rollback', [AdministrationController::class, 'configurationRollback']);
            Route::post('configurations/{key}/refresh-cache', [AdministrationController::class, 'configurationRefresh']);
            Route::get('configurations/{key}', [AdministrationController::class, 'configuration']);
            Route::put('configurations/{key}', [AdministrationController::class, 'updateConfiguration']);
            Route::get('modules', [AdministrationController::class, 'modules']);
            Route::get('modules/{module}', [AdministrationController::class, 'module']);
            Route::get('features', [AdministrationController::class, 'features']);
            Route::put('features/{feature}', [AdministrationController::class, 'updateFeature']);
            Route::get('health', [AdministrationController::class, 'health']);
            Route::get('health-score', [AdministrationController::class, 'healthScore']);
            Route::get('health/{check}', [AdministrationController::class, 'healthCheck'])->whereIn('check', ['database', 'cache', 'storage', 'queue']);
            Route::get('security', [AdministrationController::class, 'security']);
            Route::get('security/governance', [AdministrationController::class, 'securityGovernance']);
            Route::get('security/health', [AdministrationController::class, 'securityHealth']);
            Route::get('security/incidents', [AdministrationController::class, 'securityIncidents']);
            Route::get('security/incidents/statistics', [AdministrationController::class, 'incidentStatistics']);
            Route::get('security/alerts', [AdministrationController::class, 'securityAlerts']);
            Route::get('security/{section}', [AdministrationController::class, 'securitySection'])->whereIn('section', ['permissions', 'roles']);
            Route::get('monitoring', [AdministrationController::class, 'monitoring']);
            Route::get('monitoring/summary', [AdministrationController::class, 'monitoringSummary']);
            Route::get('monitoring/performance', [AdministrationController::class, 'performance']);
            Route::get('monitoring/capacity', [AdministrationController::class, 'capacity']);
            Route::get('monitoring/alerts', [AdministrationController::class, 'alerts']);
            Route::get('monitoring/{check}', [AdministrationController::class, 'monitoringCheck'])->whereIn('check', ['application', 'cache', 'database', 'queue', 'worker', 'scheduler', 'storage', 'api', 'integration']);
            Route::get('audit', [AdministrationController::class, 'audit']);
            Route::get('audit/center', [AdministrationController::class, 'auditCenter']);
            Route::get('audit/statistics', [AdministrationController::class, 'auditStatistics']);
            Route::get('operational-dashboard', [AdministrationController::class, 'operationalDashboard']);
            Route::get('backup', [AdministrationController::class, 'backup']);
            Route::get('backup/policy', [AdministrationController::class, 'backupPolicy']);
            Route::get('backup/plans', [AdministrationController::class, 'backupPlans']);
            Route::get('backup/history', [AdministrationController::class, 'backupHistory']);
            Route::get('backup/execution', [AdministrationController::class, 'backupExecution']);
            Route::get('backup/verification', [AdministrationController::class, 'backupVerification']);
            Route::get('restore/requests', [AdministrationController::class, 'restoreRequests']);
            Route::get('restore/validation', [AdministrationController::class, 'restoreValidation']);
            Route::post('restore/dry-run', [AdministrationController::class, 'restoreDryRun']);
            Route::get('disaster-recovery/plan', [AdministrationController::class, 'disasterRecoveryPlan']);
            Route::get('disaster-recovery/readiness', [AdministrationController::class, 'disasterRecoveryReadiness']);
            Route::get('disaster-recovery/checklist', [AdministrationController::class, 'recoveryChecklist']);
            Route::get('integration', [AdministrationController::class, 'integration']);
        });
    }
}
