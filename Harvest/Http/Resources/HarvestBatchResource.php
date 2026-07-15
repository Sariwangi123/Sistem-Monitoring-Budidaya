<?php

namespace Harvest\Http\Resources;

use MasterData\Http\Resources\BaseResource;
use Illuminate\Http\Request;

class HarvestBatchResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'harvest_id' => $this->harvest_id,
            'culture_cycle_id' => $this->culture_cycle_id,
            'batch_code' => $this->batch_code,
            'batch_name' => $this->batch_name,
            'harvest_date' => $this->harvest_date?->format('Y-m-d'),
            'harvest_population' => $this->harvest_population,
            'gross_weight' => $this->gross_weight,
            'net_weight' => $this->net_weight,
            'average_weight' => $this->average_weight,
            'status' => $this->status,
            'notes' => $this->notes,
            ...$this->getAuditFields($request),
        ];
    }
}