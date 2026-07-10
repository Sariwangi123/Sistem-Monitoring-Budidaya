<?php

namespace Warehouse\Http\Resources;

use Illuminate\Http\Request;
use MasterData\Http\Resources\BaseResource;

final class InventoryItemResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'item_category_id' => $this->item_category_id,
            'unit_id' => $this->unit_id,
            'supplier_id' => $this->supplier_id,
            'item_code' => $this->item_code,
            'item_name' => $this->item_name,
            'brand' => $this->brand,
            'specification' => $this->specification,
            'minimum_stock' => $this->minimum_stock,
            'maximum_stock' => $this->maximum_stock,
            'reorder_level' => $this->reorder_level,
            'status' => $this->status,
            ...$this->getAuditFields($request),
        ];
    }
}
