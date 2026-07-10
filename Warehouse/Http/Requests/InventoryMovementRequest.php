<?php

namespace Warehouse\Http\Requests;

use Illuminate\Validation\Rule;
use MasterData\Http\Requests\BaseRequest;

final class InventoryMovementRequest extends BaseRequest
{
    public function rules(): array
    {
        $uuid = $this->route('inventory_movement') ?? $this->route('id');

        return [
            'inventory_item_id' => ['required', 'integer', 'exists:inventory_items,id'],
            'warehouse_id' => ['required', 'integer', 'exists:warehouses,id'],
            'warehouse_location_id' => ['required', 'integer', 'exists:warehouse_locations,id'],
            'batch_id' => ['nullable', 'integer', 'exists:inventory_batches,id'],
            'culture_cycle_id' => ['nullable', 'integer', 'exists:culture_cycles,id'],
            'activity_id' => ['nullable', 'integer', 'exists:activities,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'movement_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('inventory_movements', 'movement_number')->ignore($uuid, 'uuid'),
            ],
            'movement_type' => ['required', 'string', Rule::in(['Stock In', 'Stock Out', 'Transfer In', 'Transfer Out', 'Adjustment Plus', 'Adjustment Minus'])],
            'movement_date' => ['required', 'date'],
            'quantity' => ['required', 'numeric', 'min:0.01'],
            'unit_cost' => ['sometimes', 'numeric', 'min:0'],
            'total_cost' => ['sometimes', 'numeric', 'min:0'],
            'reference_type' => ['nullable', 'string', 'max:255'],
            'reference_uuid' => ['nullable', 'uuid'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
