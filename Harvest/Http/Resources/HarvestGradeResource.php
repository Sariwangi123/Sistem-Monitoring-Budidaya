<?php

namespace Harvest\Http\Resources;

use MasterData\Http\Resources\BaseResource;
use Illuminate\Http\Request;

class HarvestGradeResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'harvest_id' => $this->harvest_id,
            'harvest_batch_id' => $this->harvest_batch_id,
            'grade_code' => $this->grade_code,
            'grade_name' => $this->grade_name,
            'fish_count' => $this->fish_count,
            'total_weight' => $this->total_weight,
            'average_weight' => $this->average_weight,
            'quality_status' => $this->quality_status,
            'notes' => $this->notes,
            ...$this->getAuditFields($request),
        ];
    }
}