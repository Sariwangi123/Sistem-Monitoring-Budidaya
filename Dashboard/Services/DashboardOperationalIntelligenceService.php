<?php

namespace Dashboard\Services;

use Dashboard\Repositories\Contracts\DashboardRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

final class DashboardOperationalIntelligenceService
{
    public function __construct(private DashboardRepositoryInterface $repository)
    {
    }

    public function build(array $roleSlugs, array $filters): array
    {
        $snapshot = $this->repository->getOperationalSnapshot($this->perPage($filters));
        $summary = $this->summary($snapshot);
        $health = $this->health($summary);

        return [
            'operational_summary' => $summary,
            'kpi_intelligence' => $this->kpi($summary),
            'trend_indicators' => $this->trends($summary),
            'comparative_indicators' => $this->comparisons($filters),
            'insight_cards' => $this->insights($summary, $health),
            'recommendations' => $this->recommendations($summary, $health),
            'farm_health_summary' => $health['farm'],
            'pond_health_summary' => $health['pond'],
            'financial_health_summary' => $health['financial'],
            'inventory_health_summary' => $health['inventory'],
            'production_health_summary' => $health['production'],
            'meta' => [
                'mode' => 'rule_based',
                'read_only' => true,
                'roles' => $roleSlugs,
            ],
        ];
    }

    public function kpiItems(array $roleSlugs, array $filters): array
    {
        return $this->build($roleSlugs, $filters)['kpi_intelligence']['items'];
    }

    public function alerts(array $roleSlugs, array $filters): array
    {
        $intelligence = $this->build($roleSlugs, $filters);

        return array_values(array_map(
            fn (array $recommendation): array => [
                'id' => $recommendation['key'],
                'title' => $recommendation['title'],
                'message' => $recommendation['description'],
                'severity' => $this->severityForPriority($recommendation['priority']),
                'category' => $recommendation['source'],
                'status' => 'Open',
                'recommended_action' => $recommendation['action'],
            ],
            $intelligence['recommendations']
        ));
    }

    private function summary(array $snapshot): array
    {
        return [
            'farm_count' => $this->total($snapshot['farms'] ?? null),
            'active_culture_cycle_count' => $this->total($snapshot['culture_cycles'] ?? null),
            'daily_activity_count' => $this->total($snapshot['activities'] ?? null),
            'current_stock_count' => $this->total($snapshot['inventory_stocks'] ?? null),
            'harvest_record_count' => $this->total($snapshot['harvests'] ?? null),
            'financial_summary_count' => $this->total($snapshot['financial_summaries'] ?? null),
            'available_modules' => $this->availableModules($snapshot),
        ];
    }

    private function kpi(array $summary): array
    {
        return [
            'items' => [
                $this->kpiItem('active_cycles', 'Active Cycle', $summary['active_culture_cycle_count'], 'Production'),
                $this->kpiItem('daily_activities', 'Daily Activities', $summary['daily_activity_count'], 'Operations'),
                $this->kpiItem('stock_records', 'Stock', $summary['current_stock_count'], 'Inventory'),
                $this->kpiItem('harvest_records', 'Harvest', $summary['harvest_record_count'], 'Harvest'),
                $this->kpiItem('financial_summaries', 'Financial Summary', $summary['financial_summary_count'], 'Finance'),
            ],
            'trend' => $this->trends($summary),
            'comparison' => [],
        ];
    }

    private function kpiItem(string $key, string $label, int $value, string $source): array
    {
        return [
            'key' => $key,
            'label' => $label,
            'value' => (string) $value,
            'trend' => $value > 0 ? 'Data available' : 'No data',
            'tone' => $value > 0 ? 'good' : 'warning',
            'source' => $source,
        ];
    }

    private function trends(array $summary): array
    {
        return [
            $this->trend('production_trend', 'Production Trend', $summary['active_culture_cycle_count']),
            $this->trend('inventory_trend', 'Inventory Trend', $summary['current_stock_count']),
            $this->trend('harvest_trend', 'Harvest Trend', $summary['harvest_record_count']),
            $this->trend('financial_trend', 'Financial Trend', $summary['financial_summary_count']),
        ];
    }

    private function trend(string $key, string $label, int $value): array
    {
        return [
            'key' => $key,
            'label' => $label,
            'direction' => $value > 0 ? 'stable' : 'unknown',
            'indicator' => $value > 0 ? 'Data source available' : 'Waiting for source data',
        ];
    }

    private function comparisons(array $filters): array
    {
        return [
            'farm_vs_farm' => $this->comparisonStatus($filters, 'farm_id'),
            'pond_vs_pond' => $this->comparisonStatus($filters, 'pond_id'),
            'culture_cycle_vs_culture_cycle' => $this->comparisonStatus($filters, 'culture_cycle_id'),
            'financial_period_vs_financial_period' => $this->comparisonStatus($filters, 'financial_period_id'),
        ];
    }

    private function comparisonStatus(array $filters, string $filterKey): array
    {
        return [
            'filter' => $filterKey,
            'status' => isset($filters[$filterKey]) ? 'filtered' : 'not_filtered',
            'message' => isset($filters[$filterKey])
                ? 'Comparison is scoped by selected filter.'
                : 'Select a filter to narrow comparative context.',
        ];
    }

    private function health(array $summary): array
    {
        return [
            'farm' => $this->healthCard('Farm Health', $summary['farm_count'], 'Master Data'),
            'pond' => $this->healthCard('Pond Health', $summary['active_culture_cycle_count'], 'Culture Cycle'),
            'financial' => $this->healthCard('Financial Health', $summary['financial_summary_count'], 'Finance'),
            'inventory' => $this->healthCard('Inventory Health', $summary['current_stock_count'], 'Warehouse'),
            'production' => $this->healthCard('Production Health', $summary['active_culture_cycle_count'] + $summary['daily_activity_count'], 'Production'),
        ];
    }

    private function healthCard(string $label, int $signal, string $source): array
    {
        return [
            'label' => $label,
            'score' => $signal > 0 ? 75 : 45,
            'status' => $signal > 0 ? 'Monitored' : 'Needs Data',
            'source' => $source,
            'signal_count' => $signal,
        ];
    }

    private function insights(array $summary, array $health): array
    {
        return [
            [
                'key' => 'operational-coverage',
                'title' => 'Operational Coverage',
                'description' => count($summary['available_modules']).' business modules provide dashboard signals.',
                'tone' => count($summary['available_modules']) >= 4 ? 'good' : 'warning',
            ],
            [
                'key' => 'production-health',
                'title' => 'Production Health',
                'description' => 'Production status is '.$health['production']['status'].'.',
                'tone' => $health['production']['score'] >= 70 ? 'good' : 'warning',
            ],
            [
                'key' => 'financial-health',
                'title' => 'Financial Health',
                'description' => 'Financial status is '.$health['financial']['status'].'.',
                'tone' => $health['financial']['score'] >= 70 ? 'good' : 'warning',
            ],
        ];
    }

    private function recommendations(array $summary, array $health): array
    {
        $recommendations = [];

        if ($summary['current_stock_count'] === 0) {
            $recommendations[] = $this->recommendation('inventory-review', 'Review inventory stock visibility', 'Warehouse', 'Warning', 'Open stock dashboard and verify current stock records.');
        }

        if ($summary['harvest_record_count'] === 0) {
            $recommendations[] = $this->recommendation('harvest-schedule-review', 'Review upcoming harvest schedule', 'Harvest', 'Information', 'Check harvest planning widgets before production meeting.');
        }

        if ($health['financial']['score'] < 70) {
            $recommendations[] = $this->recommendation('financial-summary-review', 'Review financial summary coverage', 'Finance', 'Warning', 'Open finance workspace and validate financial summary availability.');
        }

        if ($recommendations === []) {
            $recommendations[] = $this->recommendation('daily-review', 'Continue daily operational review', 'Operations', 'Information', 'Refresh dashboard periodically and monitor alerts.');
        }

        return $recommendations;
    }

    private function recommendation(string $key, string $title, string $source, string $priority, string $action): array
    {
        return [
            'key' => $key,
            'title' => $title,
            'source' => $source,
            'priority' => $priority,
            'description' => $title.' based on existing dashboard signals.',
            'action' => $action,
            'mode' => 'rule_based',
        ];
    }

    private function severityForPriority(string $priority): string
    {
        return match ($priority) {
            'Critical' => 'Critical',
            'Warning' => 'Warning',
            default => 'Information',
        };
    }

    private function availableModules(array $snapshot): array
    {
        return array_values(array_filter(array_keys($snapshot), fn (string $key): bool => $this->total($snapshot[$key]) > 0));
    }

    private function total(mixed $value): int
    {
        return $value instanceof LengthAwarePaginator ? $value->total() : 0;
    }

    private function perPage(array $filters): int
    {
        return min(max((int) ($filters['per_page'] ?? 15), 1), 100);
    }
}
