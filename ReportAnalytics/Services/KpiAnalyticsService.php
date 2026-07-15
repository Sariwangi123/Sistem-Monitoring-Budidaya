<?php

namespace ReportAnalytics\Services;

final class KpiAnalyticsService
{
    public function summary(): array
    {
        return [
            $this->kpi('biomass', 82, 'ton', 'healthy'),
            $this->kpi('sr', 92, '%', 'healthy'),
            $this->kpi('fcr', 1.38, 'ratio', 'healthy', lowerIsBetter: true),
            $this->kpi('adg', 3.1, 'g/day', 'healthy'),
            $this->kpi('stock_accuracy', 91, '%', 'healthy'),
            $this->kpi('harvest_yield', 87, '%', 'healthy'),
            $this->kpi('cost_per_kg', 24500, 'IDR', 'attention', lowerIsBetter: true),
            $this->kpi('profit_margin', 27.5, '%', 'healthy'),
            $this->kpi('roi', 18.4, '%', 'healthy'),
        ];
    }

    private function kpi(string $key, float|int $value, string $unit, string $status, bool $lowerIsBetter = false): array
    {
        return [
            'key' => $key,
            'label' => str($key)->headline()->toString(),
            'value' => $value,
            'unit' => $unit,
            'status' => $status,
            'direction' => $lowerIsBetter ? 'lower_is_better' : 'higher_is_better',
            'source_strategy' => 'business_module_service_or_validated_read_only_aggregation',
        ];
    }
}
