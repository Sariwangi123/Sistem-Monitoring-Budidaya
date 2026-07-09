<?php

namespace MasterData\Http\Resources;

use Illuminate\Http\Request;

class CompanyResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'company_code' => $this->company_code,
            'company_name' => $this->company_name,
            'company_type' => $this->company_type,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'province_id' => $this->province_id,
            'city_id' => $this->city_id,
            'district_id' => $this->district_id,
            'village_id' => $this->village_id,
            'postal_code' => $this->postal_code,
            'tax_number' => $this->tax_number,
            'logo' => $this->logo,
            'is_active' => $this->is_active,
            ...$this->getAuditFields($request),
        ];
    }
}