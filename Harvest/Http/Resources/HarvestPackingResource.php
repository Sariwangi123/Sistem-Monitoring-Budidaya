<?php

namespace Harvest\Http\Resources;

use MasterData\Http\Resources\BaseResource;
use Illuminate\Http\Request;

class HarvestPackingResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'harvest_id' => $this->harvest_id,
            'harvest_batch_id' => $this->harvest_batch_id,
            'harvest_grade_id' => $this->harvest_grade_id,
            'operator_user_id' => $this->operator_user_id,
            'packing_code' => $this->packing_code,
            'packing_date' => $this->packing_date?->format('Y-m-d'),
            'package_type' => $this->package_type,
            'package_quantity' => $this->package_quantity,
            'net_weight' => $this->net_weight,
            'gross_weight' => $this->gross_weight,
            'status' => $this->status,
            'notes' => $this->notes,
            ...$this->getAuditFields($request),
        ];
    }
}