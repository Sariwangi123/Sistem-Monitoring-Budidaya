<?php

namespace MasterData\Http\Resources;

use Illuminate\Http\Request;

class DistrictResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'district_code' => $this->district_code,
            'district_name' => $this->district_name,
            'city_id' => $this->city_id,
            ...$this->getAuditFields($request),
        ];
    }
}