<?php

namespace MasterData\Http\Resources;

use Illuminate\Http\Request;

class ProvinceResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'province_code' => $this->province_code,
            'province_name' => $this->province_name,
            ...$this->getAuditFields($request),
        ];
    }
}