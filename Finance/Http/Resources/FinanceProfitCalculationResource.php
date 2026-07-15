<?php

namespace Finance\Http\Resources;

use Illuminate\Http\Request;
use MasterData\Http\Resources\BaseResource;

final class FinanceProfitCalculationResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'company_id' => $this->company_id,
            'farm_id' => $this->farm_id,
            'culture_cycle_id' => $this->culture_cycle_id,
            'harvest_id' => $this->harvest_id,
            'cost_center_id' => $this->cost_center_id,
            'calculation_number' => $this->calculation_number,
            'calculation_date' => $this->calculation_date?->format('Y-m-d'),
            'period_start' => $this->period_start?->format('Y-m-d'),
            'period_end' => $this->period_end?->format('Y-m-d'),
            'feed_cost' => $this->feed_cost,
            'medicine_cost' => $this->medicine_cost,
            'labor_cost' => $this->labor_cost,
            'utility_cost' => $this->utility_cost,
            'maintenance_cost' => $this->maintenance_cost,
            'operational_cost' => $this->operational_cost,
            'cost_of_production' => $this->cost_of_production,
            'total_revenue' => $this->total_revenue,
            'gross_profit' => $this->gross_profit,
            'net_profit' => $this->net_profit,
            'harvest_weight' => $this->harvest_weight,
            'cost_per_kg' => $this->cost_per_kg,
            'status' => $this->status,
            'notes' => $this->notes,
            ...$this->getAuditFields($request),
        ];
    }
}
