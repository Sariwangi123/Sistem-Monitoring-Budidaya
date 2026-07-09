<?php

namespace MasterData\Http\Resources;

use Illuminate\Http\Request;

class CityResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'city_code' => $this->city_code,
            'city_name' => $this->city_name,
            'province_id' => $this->province_id,
            ...$this->getAuditFields($request),
        ];
    }
}