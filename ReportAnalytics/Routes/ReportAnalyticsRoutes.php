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
            Route::get('report-registry', [ReportAnalyticsController::class, 'registry']);
            Route::get('report-registry/{report}', [ReportAnalyticsController::class, 'registryDetail']);
            Route::get('operational', [ReportAnalyticsController::class, 'operational']);
            Route::get('production', [ReportAnalyticsController::class, 'production']);
            Route::get('inventory', [ReportAnalyticsController::class, 'inventory']);
            Route::get('harvest', [ReportAnalyticsController::class, 'harvest']);
            Route::get('finance', [ReportAnalyticsController::class, 'finance']);
            Route::get('executive', [ReportAnalyticsController::class, 'executive']);
            Route::get('kpi', [ReportAnalyticsController::class, 'kpi']);
            Route::get('audit', [ReportAnalyticsController::class, 'audit']);
            Route::get('historical', [ReportAnalyticsController::class, 'historical']);
            Route::get('comparative', [ReportAnalyticsController::class, 'comparative']);
            Route::get('analytics', [ReportAnalyticsController::class, 'analytics']);
            Route::get('business-intelligence', [ReportAnalyticsController::class, 'businessIntelligence']);
            Route::get('executive-analytics', [ReportAnalyticsController::class, 'executiveAnalytics']);
            Route::get('trend-analysis', [ReportAnalyticsController::class, 'trendAnalysis']);
            Route::get('comparative-analysis', [ReportAnalyticsController::class, 'comparativeAnalysis']);
            Route::get('kpi-analytics', [ReportAnalyticsController::class, 'kpiAnalytics']);
            Route::get('executive-scorecard', [ReportAnalyticsController::class, 'executiveScorecard']);
            Route::get('benchmark-analysis', [ReportAnalyticsController::class, 'benchmarkAnalysis']);
            Route::get('decision-support-insights', [ReportAnalyticsController::class, 'decisionSupportInsights']);
            Route::post('generate', [ReportAnalyticsController::class, 'generate']);
            Route::get('export/{report}', [ReportAnalyticsController::class, 'export']);
            Route::get('schedules', [ReportAnalyticsController::class, 'schedules']);
            Route::post('schedules', [ReportAnalyticsController::class, 'storeSchedule']);
            Route::delete('schedules/{uuid}', [ReportAnalyticsController::class, 'destroySchedule']);
        });
    }
}
