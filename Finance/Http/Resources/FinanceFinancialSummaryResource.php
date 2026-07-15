<?php

namespace Finance\Http\Resources;

use Illuminate\Http\Request;
use MasterData\Http\Resources\BaseResource;

final class FinanceFinancialSummaryResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'company_id' => $this->company_id,
            'farm_id' => $this->farm_id,
            'culture_cycle_id' => $this->culture_cycle_id,
            'cost_center_id' => $this->cost_center_id,
            'summary_number' => $this->summary_number,
            'summary_type' => $this->summary_type,
            'period_start' => $this->period_start?->format('Y-m-d'),
            'period_end' => $this->period_end?->format('Y-m-d'),
            'total_expense' => $this->total_expense,
            'total_revenue' => $this->total_revenue,
            'cost_of_production' => $this->cost_of_production,
            'gross_profit' => $this->gross_profit,
            'net_profit' => $this->net_profit,
            'profit_margin' => $this->profit_margin,
            'status' => $this->status,
            'notes' => $this->notes,
            ...$this->getAuditFields($request),
        ];
    }
}
