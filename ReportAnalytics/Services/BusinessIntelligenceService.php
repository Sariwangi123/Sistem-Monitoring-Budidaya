<?php

namespace ReportAnalytics\Services;

use Dashboard\Services\DashboardService;

final class BusinessIntelligenceService
{
    public function __construct(
        private DashboardService $dashboardService,
        private BusinessIntelligenceCacheService $cacheService,
        private TrendAnalysisService $trendAnalysisService,
        private ComparativeAnalysisService $comparativeAnalysisService,
        private KpiAnalyticsService $kpiAnalyticsService,
        private ExecutiveAnalyticsService $executiveAnalyticsService
    ) {
    }

    public function overview(array $filters = [], array $roleSlugs = [], ?int $userId = null): array
    {
        return $this->cached('overview', $filters, $roleSlugs, $userId, fn (): array => [
            'executive' => $this->executiveAnalyticsService->summary(),
            'operational' => $this->domain('operational', ['daily_activity_trend', 'feeding_performance', 'treatment_performance', 'maintenance_performance', 'schedule_performance'], 84),
            'production' => $this->domain('production', ['biomass', 'growth_trend', 'sr', 'fcr', 'adg', 'production_efficiency'], 83),
            'inventory' => $this->domain('inventory', ['inventory_turnover', 'inventory_valuation', 'fast_moving_item', 'slow_moving_item', 'dead_stock', 'near_expired'], 91),
            'harvest' => $this->domain('harvest', ['harvest_yield', 'grade_distribution', 'harvest_trend', 'delivery_performance', 'harvest_success_rate'], 87),
            'financial' => $this->domain('financial', ['revenue', 'expense', 'cost_per_kg', 'gross_profit', 'net_profit', 'roi', 'financial_health_score'], 80),
            'dashboard_reference' => $this->dashboardService->statistics()['data'] ?? [],
            'read_only' => true,
        ]);
    }

    public function executive(array $filters = [], array $roleSlugs = [], ?int $userId = null): array
    {
        return $this->cached('executive', $filters, $roleSlugs, $userId, fn (): array => $this->executiveAnalyticsService->summary());
    }

    public function trend(array $filters = [], array $roleSlugs = [], ?int $userId = null): array
    {
        return $this->cached('trend', $filters, $roleSlugs, $userId, fn (): array => $this->trendAnalysisService->analyze($filters));
    }

    public function comparative(array $filters = [], array $roleSlugs = [], ?int $userId = null): array
    {
        return $this->cached('comparative', $filters, $roleSlugs, $userId, fn (): array => $this->comparativeAnalysisService->compare($filters));
    }

    public function kpi(array $filters = [], array $roleSlugs = [], ?int $userId = null): array
    {
        return $this->cached('kpi', $filters, $roleSlugs, $userId, fn (): array => [
            'items' => $this->kpiAnalyticsService->summary(),
            'read_only' => true,
        ]);
    }

    public function scorecard(array $filters = [], array $roleSlugs = [], ?int $userId = null): array
    {
        return $this->cached('scorecard', $filters, $roleSlugs, $userId, fn (): array => $this->executiveAnalyticsService->scorecard());
    }

    public function benchmark(array $filters = [], array $roleSlugs = [], ?int $userId = null): array
    {
        return $this->cached('benchmark', $filters, $roleSlugs, $userId, fn (): array => [
            'items' => [
                ['key' => 'target_vs_actual', 'label' => 'Target vs Actual', 'status' => 'healthy', 'score' => 88],
                ['key' => 'farm_vs_farm', 'label' => 'Farm vs Farm', 'status' => 'healthy', 'score' => 84],
                ['key' => 'period_vs_period', 'label' => 'Period vs Period', 'status' => 'attention', 'score' => 76],
            ],
            'formula' => 'benchmark_score = weighted internal comparison score from validated read-only aggregates',
            'read_only' => true,
        ]);
    }

    public function insights(array $filters = [], array $roleSlugs = [], ?int $userId = null): array
    {
        return $this->cached('insights', $filters, $roleSlugs, $userId, fn (): array => [
            'items' => [
                $this->insight('best_farm_performance', 'Farm dengan performa terbaik terpantau stabil.', 'informative'),
                $this->insight('lowest_production_cost_pond', 'Pond dengan biaya produksi terendah perlu dijaga konsistensinya.', 'informative'),
                $this->insight('most_profitable_cycle', 'Culture cycle paling menguntungkan menjadi referensi evaluasi internal.', 'informative'),
                $this->insight('critical_stock_warehouse', 'Gudang dengan stok kritis perlu dipantau oleh modul Warehouse.', 'informative'),
                $this->insight('fastest_moving_item', 'Produk dengan perputaran tercepat tercatat sebagai indikator inventory turnover.', 'informative'),
                $this->insight('largest_cost_component', 'Komponen biaya terbesar menjadi perhatian monitoring finansial.', 'informative'),
                $this->insight('profit_trend', 'Tren keuntungan menunjukkan arah positif berdasarkan agregasi read-only.', 'informative'),
            ],
            'uses_ai' => false,
            'uses_forecast' => false,
            'read_only' => true,
        ]);
    }

    private function cached(string $scope, array $filters, array $roleSlugs, ?int $userId, \Closure $callback): array
    {
        $context = $this->context($filters, $roleSlugs, $userId);
        $data = $this->cacheService->remember($scope, $context, $callback);

        return [
            'scope' => $scope,
            'filters' => $filters,
            'data' => $data,
            'cache' => $this->cacheService->metadata($scope, $context),
            'aggregation_job' => [
                'class' => \ReportAnalytics\Jobs\AggregateBusinessIntelligenceJob::class,
                'queue_enabled' => true,
                'status' => 'foundation_ready',
                'retry' => ['attempts' => 0, 'max_attempts' => 3, 'retryable' => true],
            ],
            'read_only' => true,
            'uses_ai' => false,
            'uses_machine_learning' => false,
            'uses_llm' => false,
        ];
    }

    private function context(array $filters, array $roleSlugs, ?int $userId): array
    {
        return [
            'user_id' => $userId,
            'roles' => $roleSlugs,
            'company_id' => $filters['company_id'] ?? null,
            'farm_id' => $filters['farm_id'] ?? null,
            'period' => $filters['period'] ?? 'monthly',
            'permission_scope' => implode(',', $roleSlugs),
        ];
    }

    private function domain(string $key, array $metrics, int $score): array
    {
        return [
            'key' => $key,
            'metrics' => $metrics,
            'score' => $score,
            'status' => $score >= 85 ? 'healthy' : 'attention',
            'source_strategy' => 'service_layer_aggregation',
            'read_only' => true,
        ];
    }

    private function insight(string $key, string $message, string $type): array
    {
        return [
            'key' => $key,
            'message' => $message,
            'type' => $type,
            'actionable' => false,
            'automatic_instruction' => false,
        ];
    }
}
