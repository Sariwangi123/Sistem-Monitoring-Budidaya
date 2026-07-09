<?php

namespace MasterData\Http\Resources;

use Illuminate\Http\Request;

class FarmResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'farm_code' => $this->farm_code,
            'farm_name' => $this->farm_name,
            'company_id' => $this->company_id,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'province_id' => $this->province_id,
            'city_id' => $this->city_id,
            'district_id' => $this->district_id,
            'village_id' => $this->village_id,
            'postal_code' => $this->postal_code,
            'is_active' => $this->is_active,
            ...$this->getAuditFields($request),
        ];
    }
}