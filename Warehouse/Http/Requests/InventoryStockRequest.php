<?php

namespace Warehouse\Http\Requests;

use MasterData\Http\Requests\BaseRequest;

final class InventoryStockRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'inventory_item_id' => ['required', 'integer', 'exists:inventory_items,id'],
            'warehouse_location_id' => ['required', 'integer', 'exists:warehouse_locations,id'],
            'batch_id' => ['nullable', 'integer', 'exists:inventory_batches,id'],
            'current_quantity' => ['sometimes', 'numeric', 'min:0'],
            'reserved_quantity' => ['sometimes', 'numeric', 'min:0'],
            'available_quantity' => ['sometimes', 'numeric', 'min:0'],
            'last_movement_at' => ['nullable', 'date'],
        ];
    }
}
