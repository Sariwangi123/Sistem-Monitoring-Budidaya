<?php

namespace Warehouse\Http\Resources;

use Illuminate\Http\Request;
use MasterData\Http\Resources\BaseResource;

final class StockOpnameDetailResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'stock_opname_id' => $this->stock_opname_id,
            'inventory_item_id' => $this->inventory_item_id,
            'batch_id' => $this->batch_id,
            'system_quantity' => $this->system_quantity,
            'physical_quantity' => $this->physical_quantity,
            'difference_quantity' => $this->difference_quantity,
            'adjustment_required' => $this->adjustment_required,
            'notes' => $this->notes,
            ...$this->getAuditFields($request),
        ];
    }
}
