<?php

namespace MasterData\Http\Resources;

use Illuminate\Http\Request;

class UnitResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'unit_code' => $this->unit_code,
            'unit_name' => $this->unit_name,
            'unit_category' => $this->unit_category,
            'description' => $this->description,
            ...$this->getAuditFields($request),
        ];
    }
}