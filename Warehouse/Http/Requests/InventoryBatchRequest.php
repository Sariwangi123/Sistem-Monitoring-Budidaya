<?php

namespace Warehouse\Http\Requests;

use Illuminate\Validation\Rule;
use MasterData\Http\Requests\BaseRequest;

final class InventoryBatchRequest extends BaseRequest
{
    public function rules(): array
    {
        $uuid = $this->route('inventory_batch') ?? $this->route('id');

        return [
            'inventory_item_id' => ['required', 'integer', 'exists:inventory_items,id'],
            'warehouse_location_id' => ['required', 'integer', 'exists:warehouse_locations,id'],
            'batch_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('inventory_batches', 'batch_number')
                    ->where('inventory_item_id', $this->input('inventory_item_id'))
                    ->ignore($uuid, 'uuid'),
            ],
            'lot_number' => ['nullable', 'string', 'max:255'],
            'production_date' => ['nullable', 'date'],
            'expired_date' => ['nullable', 'date', 'after_or_equal:production_date'],
            'received_date' => ['required', 'date'],
            'status' => ['required', 'string', Rule::in(['Available', 'Near Expired', 'Expired', 'Consumed'])],
        ];
    }
}
