<?php

namespace Harvest\Http\Resources;

use MasterData\Http\Resources\BaseResource;
use Illuminate\Http\Request;

class HarvestDeliveryResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'harvest_id' => $this->harvest_id,
            'harvest_packing_id' => $this->harvest_packing_id,
            'customer_id' => $this->customer_id,
            'driver_user_id' => $this->driver_user_id,
            'delivery_code' => $this->delivery_code,
            'document_number' => $this->document_number,
            'delivery_date' => $this->delivery_date?->format('Y-m-d'),
            'vehicle_number' => $this->vehicle_number,
            'driver_name' => $this->driver_name,
            'package_quantity' => $this->package_quantity,
            'delivered_weight' => $this->delivered_weight,
            'delivery_status' => $this->delivery_status,
            'notes' => $this->notes,
            ...$this->getAuditFields($request),
        ];
    }
}