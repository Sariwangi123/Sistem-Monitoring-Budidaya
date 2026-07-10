<?php

namespace Warehouse\Http\Resources;

use Illuminate\Http\Request;
use MasterData\Http\Resources\BaseResource;

final class WarehouseLocationResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'warehouse_id' => $this->warehouse_id,
            'location_code' => $this->location_code,
            'location_name' => $this->location_name,
            'description' => $this->description,
            'status' => $this->status,
            ...$this->getAuditFields($request),
        ];
    }
}
