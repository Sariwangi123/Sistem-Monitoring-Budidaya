<?php

namespace ReportAnalytics\Services;

final class ComparativeAnalysisService
{
    public function compare(array $filters = []): array
    {
        $items = [
            $this->item('current_vs_previous', 83.0, 78.0, 'Production efficiency'),
            $this->item('target_vs_actual', 91.0, 88.0, 'Stock accuracy'),
            $this->item('farm_vs_farm', 27.5, 25.0, 'Profit margin'),
            $this->item('pond_vs_pond', 1.38, 1.46, 'FCR', lowerIsBetter: true),
            $this->item('culture_cycle_vs_culture_cycle', 92.0, 89.0, 'Survival rate'),
            $this->item('financial_period_vs_financial_period', 18.4, 16.2, 'ROI'),
        ];

        return [
            'scope' => [
                'company_id' => $filters['company_id'] ?? null,
                'farm_id' => $filters['farm_id'] ?? null,
                'pond_id' => $filters['pond_id'] ?? null,
                'culture_cycle_id' => $filters['culture_cycle_id'] ?? null,
                'financial_period_id' => $filters['financial_period_id'] ?? null,
            ],
            'items' => $items,
            'read_only' => true,
        ];
    }

    private function item(string $key, float $current, float $comparison, string $label, bool $lowerIsBetter = false): array
    {
        $difference = round($current - $comparison, 2);
        $percentage = $comparison === 0.0 ? 0.0 : round(($difference / $comparison) * 100, 2);
        $improved = $lowerIsBetter ? $difference <= 0 : $difference >= 0;

        return [
            'key' => $key,
            'label' => $label,
            'current_value' => $current,
            'comparison_value' => $comparison,
            'absolute_difference' => $difference,
            'percentage_difference' => $percentage,
            'direction' => $difference >= 0 ? 'up' : 'down',
            'status' => $improved ? 'healthy' : 'attention',
            'formula' => 'percentage_difference = (current_value - comparison_value) / comparison_value * 100',
        ];
    }
}
