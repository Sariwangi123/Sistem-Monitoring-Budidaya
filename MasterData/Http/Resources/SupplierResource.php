<?php

namespace MasterData\Http\Resources;

use Illuminate\Http\Request;

class SupplierResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'supplier_code' => $this->supplier_code,
            'supplier_name' => $this->supplier_name,
            'supplier_type' => $this->supplier_type,
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