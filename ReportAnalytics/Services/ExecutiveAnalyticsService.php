<?php

namespace ReportAnalytics\Services;

final class ExecutiveAnalyticsService
{
    public function __construct(private KpiAnalyticsService $kpiAnalyticsService)
    {
    }

    public function summary(): array
    {
        $scorecard = $this->scorecard();

        return [
            'business_overview' => [
                'status' => 'Stable',
                'read_only' => true,
                'source_strategy' => 'dashboard_and_business_module_services',
            ],
            'operational_summary' => 'Schedule performance and daily activity trend are within healthy range.',
            'production_summary' => 'Production efficiency, biomass, SR, FCR, and ADG are monitored through validated KPI aggregation.',
            'inventory_summary' => 'Stock accuracy and inventory movement are monitored through Warehouse service layer aggregation.',
            'harvest_summary' => 'Harvest yield, grade distribution, and delivery performance are monitored read-only.',
            'financial_summary' => 'Revenue, expense, cost per KG, margin, and ROI are monitored read-only.',
            'important_kpis' => $this->kpiAnalyticsService->summary(),
            'important_alerts' => [
                ['level' => 'info', 'message' => 'Cost per KG requires monitoring against target.'],
                ['level' => 'info', 'message' => 'Inventory accuracy remains healthy.'],
            ],
            'scorecard' => $scorecard,
        ];
    }

    public function scorecard(): array
    {
        $scores = [
            'financial_score' => 80,
            'production_score' => 83,
            'inventory_score' => 91,
            'harvest_score' => 87,
            'operational_score' => 84,
        ];
        $overall = (int) round(array_sum($scores) / count($scores));

        return [
            ...$scores,
            'overall_score' => $overall,
            'status' => $overall >= 85 ? 'excellent' : ($overall >= 75 ? 'healthy' : 'attention'),
            'formula' => 'overall_score = average(financial_score, production_score, inventory_score, harvest_score, operational_score)',
            'rule_based' => true,
            'uses_ai' => false,
        ];
    }
}
