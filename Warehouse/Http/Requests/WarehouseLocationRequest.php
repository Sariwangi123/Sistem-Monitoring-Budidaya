<?php

namespace Warehouse\Http\Requests;

use Illuminate\Validation\Rule;
use MasterData\Http\Requests\BaseRequest;

final class WarehouseLocationRequest extends BaseRequest
{
    public function rules(): array
    {
        $uuid = $this->route('location') ?? $this->route('id');

        return [
            'warehouse_id' => ['required', 'integer', 'exists:warehouses,id'],
            'location_code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('warehouse_locations', 'location_code')
                    ->where('warehouse_id', $this->input('warehouse_id'))
                    ->ignore($uuid, 'uuid'),
            ],
            'location_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'string', Rule::in(['Active', 'Inactive'])],
        ];
    }
}
