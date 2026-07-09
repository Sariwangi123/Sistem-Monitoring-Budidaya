<?php

namespace MasterData\Http\Resources;

use Illuminate\Http\Request;

class PondAreaResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'pond_area_code' => $this->pond_area_code,
            'pond_area_name' => $this->pond_area_name,
            'farm_id' => $this->farm_id,
            'total_area' => $this->total_area,
            'area_unit_id' => $this->area_unit_id,
            'is_active' => $this->is_active,
            ...$this->getAuditFields($request),
        ];
    }
}