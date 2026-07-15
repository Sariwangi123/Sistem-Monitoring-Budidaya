<?php

namespace Finance\Http\Resources;

use Illuminate\Http\Request;
use MasterData\Http\Resources\BaseResource;

final class FinanceCostCenterResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'company_id' => $this->company_id,
            'farm_id' => $this->farm_id,
            'pond_id' => $this->pond_id,
            'culture_cycle_id' => $this->culture_cycle_id,
            'cost_center_code' => $this->cost_center_code,
            'cost_center_name' => $this->cost_center_name,
            'cost_center_type' => $this->cost_center_type,
            'effective_from' => $this->effective_from?->format('Y-m-d'),
            'effective_to' => $this->effective_to?->format('Y-m-d'),
            'status' => $this->status,
            'description' => $this->description,
            ...$this->getAuditFields($request),
        ];
    }
}
