<?php

namespace Warehouse\Http\Resources;

use Illuminate\Http\Request;
use MasterData\Http\Resources\BaseResource;

final class InventoryBatchResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'inventory_item_id' => $this->inventory_item_id,
            'warehouse_location_id' => $this->warehouse_location_id,
            'batch_number' => $this->batch_number,
            'lot_number' => $this->lot_number,
            'production_date' => $this->production_date?->format('Y-m-d'),
            'expired_date' => $this->expired_date?->format('Y-m-d'),
            'received_date' => $this->received_date?->format('Y-m-d'),
            'status' => $this->status,
            ...$this->getAuditFields($request),
        ];
    }
}
