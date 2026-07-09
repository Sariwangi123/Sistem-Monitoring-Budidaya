<?php

namespace MasterData\Http\Resources;

use Illuminate\Http\Request;

class MedicineResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'medicine_code' => $this->medicine_code,
            'medicine_name' => $this->medicine_name,
            'medicine_type' => $this->medicine_type,
            'is_active' => $this->is_active,
            ...$this->getAuditFields($request),
        ];
    }
}