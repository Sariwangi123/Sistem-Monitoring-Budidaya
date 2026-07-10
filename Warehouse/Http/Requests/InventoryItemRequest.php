<?php

namespace Warehouse\Http\Requests;

use Illuminate\Validation\Rule;
use MasterData\Http\Requests\BaseRequest;

final class InventoryItemRequest extends BaseRequest
{
    public function rules(): array
    {
        $uuid = $this->route('inventory_item') ?? $this->route('id');

        return [
            'item_category_id' => ['nullable', 'integer', 'exists:general_references,id'],
            'unit_id' => ['required', 'integer', 'exists:units,id'],
            'supplier_id' => ['nullable', 'integer', 'exists:suppliers,id'],
            'item_code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('inventory_items', 'item_code')->ignore($uuid, 'uuid'),
            ],
            'item_name' => ['required', 'string', 'max:255'],
            'brand' => ['nullable', 'string', 'max:255'],
            'specification' => ['nullable', 'string'],
            'minimum_stock' => ['sometimes', 'numeric', 'min:0'],
            'maximum_stock' => ['nullable', 'numeric', 'min:0'],
            'reorder_level' => ['sometimes', 'numeric', 'min:0'],
            'status' => ['required', 'string', Rule::in(['Active', 'Inactive'])],
        ];
    }
}
