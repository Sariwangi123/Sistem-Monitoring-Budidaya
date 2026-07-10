<?php

namespace Warehouse\Http\Resources;

use Illuminate\Http\Request;
use MasterData\Http\Resources\BaseResource;

final class InventoryMovementResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'inventory_item_id' => $this->inventory_item_id,
            'warehouse_id' => $this->warehouse_id,
            'warehouse_location_id' => $this->warehouse_location_id,
            'batch_id' => $this->batch_id,
            'culture_cycle_id' => $this->culture_cycle_id,
            'activity_id' => $this->activity_id,
            'user_id' => $this->user_id,
            'movement_number' => $this->movement_number,
            'movement_type' => $this->movement_type,
            'movement_date' => $this->movement_date?->format('Y-m-d'),
            'quantity' => $this->quantity,
            'unit_cost' => $this->unit_cost,
            'total_cost' => $this->total_cost,
            'reference_type' => $this->reference_type,
            'reference_uuid' => $this->reference_uuid,
            'notes' => $this->notes,
            ...$this->getAuditFields($request),
        ];
    }
}
