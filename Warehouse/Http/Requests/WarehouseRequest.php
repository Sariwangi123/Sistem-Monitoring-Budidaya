<?php

namespace Warehouse\Http\Requests;

use Illuminate\Validation\Rule;
use MasterData\Http\Requests\BaseRequest;

final class WarehouseRequest extends BaseRequest
{
    public function rules(): array
    {
        $uuid = $this->route('warehouse') ?? $this->route('id');

        return [
            'farm_id' => ['required', 'integer', 'exists:farms,id'],
            'warehouse_code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('warehouses', 'warehouse_code')->ignore($uuid, 'uuid'),
            ],
            'warehouse_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'string', Rule::in(['Active', 'Inactive'])],
        ];
    }
}
