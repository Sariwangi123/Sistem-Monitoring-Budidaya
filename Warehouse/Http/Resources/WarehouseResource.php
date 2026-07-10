<?php

namespace Warehouse\Http\Resources;

use Illuminate\Http\Request;
use MasterData\Http\Resources\BaseResource;

final class WarehouseResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'farm_id' => $this->farm_id,
            'warehouse_code' => $this->warehouse_code,
            'warehouse_name' => $this->warehouse_name,
            'description' => $this->description,
            'status' => $this->status,
            ...$this->getAuditFields($request),
        ];
    }
}
