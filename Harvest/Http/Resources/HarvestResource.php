<?php

namespace Harvest\Http\Resources;

use MasterData\Http\Resources\BaseResource;
use Illuminate\Http\Request;

class HarvestResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'company_id' => $this->company_id,
            'farm_id' => $this->farm_id,
            'pond_area_id' => $this->pond_area_id,
            'pond_id' => $this->pond_id,
            'culture_cycle_id' => $this->culture_cycle_id,
            'customer_id' => $this->customer_id,
            'responsible_user_id' => $this->responsible_user_id,
            'activity_id' => $this->activity_id,
            'harvest_code' => $this->harvest_code,
            'harvest_name' => $this->harvest_name,
            'harvest_type' => $this->harvest_type,
            'planned_harvest_date' => $this->planned_harvest_date?->format('Y-m-d'),
            'harvest_date' => $this->harvest_date?->format('Y-m-d'),
            'started_at' => $this->started_at?->format('Y-m-d H:i:s'),
            'completed_at' => $this->completed_at?->format('Y-m-d H:i:s'),
            'estimated_population' => $this->estimated_population,
            'estimated_biomass' => $this->estimated_biomass,
            'total_harvest_population' => $this->total_harvest_population,
            'total_harvest_weight' => $this->total_harvest_weight,
            'average_weight' => $this->average_weight,
            'survival_rate' => $this->survival_rate,
            'feed_conversion_ratio' => $this->feed_conversion_ratio,
            'average_daily_gain' => $this->average_daily_gain,
            'status' => $this->status,
            'notes' => $this->notes,
            ...$this->getAuditFields($request),
        ];
    }
}