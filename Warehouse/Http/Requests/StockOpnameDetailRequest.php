<?php

namespace Warehouse\Http\Requests;

use MasterData\Http\Requests\BaseRequest;

final class StockOpnameDetailRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'stock_opname_id' => ['required', 'integer', 'exists:stock_opnames,id'],
            'inventory_item_id' => ['required', 'integer', 'exists:inventory_items,id'],
            'batch_id' => ['nullable', 'integer', 'exists:inventory_batches,id'],
            'system_quantity' => ['sometimes', 'numeric', 'min:0'],
            'physical_quantity' => ['required', 'numeric', 'min:0'],
            'difference_quantity' => ['sometimes', 'numeric'],
            'adjustment_required' => ['sometimes', 'boolean'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
