<?php

namespace MasterData\Http\Resources;

use Illuminate\Http\Request;

class PondResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'pond_code' => $this->pond_code,
            'pond_name' => $this->pond_name,
            'pond_area_id' => $this->pond_area_id,
            'pond_type' => $this->pond_type,
            'width' => $this->width,
            'length' => $this->length,
            'depth' => $this->depth,
            'size_unit_id' => $this->size_unit_id,
            'is_active' => $this->is_active,
            ...$this->getAuditFields($request),
        ];
    }
}