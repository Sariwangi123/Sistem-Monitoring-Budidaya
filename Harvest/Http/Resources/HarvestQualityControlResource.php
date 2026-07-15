<?php

namespace Harvest\Http\Resources;

use MasterData\Http\Resources\BaseResource;
use Illuminate\Http\Request;

class HarvestQualityControlResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'harvest_id' => $this->harvest_id,
            'harvest_batch_id' => $this->harvest_batch_id,
            'qc_user_id' => $this->qc_user_id,
            'qc_date' => $this->qc_date?->format('Y-m-d'),
            'average_weight' => $this->average_weight,
            'fish_size' => $this->fish_size,
            'fish_condition' => $this->fish_condition,
            'damage_rate' => $this->damage_rate,
            'qc_status' => $this->qc_status,
            'qc_notes' => $this->qc_notes,
            ...$this->getAuditFields($request),
        ];
    }
}