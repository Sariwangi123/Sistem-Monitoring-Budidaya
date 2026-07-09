<?php

namespace MasterData\Http\Resources;

use Illuminate\Http\Request;

class VitaminResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'vitamin_code' => $this->vitamin_code,
            'vitamin_name' => $this->vitamin_name,
            'is_active' => $this->is_active,
            ...$this->getAuditFields($request),
        ];
    }
}