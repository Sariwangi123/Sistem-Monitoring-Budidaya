<?php

namespace Warehouse\Http\Resources;

use Illuminate\Http\Request;
use MasterData\Http\Resources\BaseResource;

final class InventoryStockResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'inventory_item_id' => $this->inventory_item_id,
            'warehouse_location_id' => $this->warehouse_location_id,
            'batch_id' => $this->batch_id,
            'current_quantity' => $this->current_quantity,
            'reserved_quantity' => $this->reserved_quantity,
            'available_quantity' => $this->available_quantity,
            'last_movement_at' => $this->last_movement_at?->format('Y-m-d H:i:s'),
            ...$this->getAuditFields($request),
        ];
    }
}
