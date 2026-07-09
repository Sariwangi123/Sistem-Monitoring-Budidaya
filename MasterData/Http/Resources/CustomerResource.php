<?php

namespace MasterData\Http\Resources;

use Illuminate\Http\Request;

class CustomerResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'customer_code' => $this->customer_code,
            'customer_name' => $this->customer_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'province_id' => $this->province_id,
            'city_id' => $this->city_id,
            'district_id' => $this->district_id,
            'village_id' => $this->village_id,
            'postal_code' => $this->postal_code,
            'tax_number' => $this->tax_number,
            'is_active' => $this->is_active,
            ...$this->getAuditFields($request),
        ];
    }
}