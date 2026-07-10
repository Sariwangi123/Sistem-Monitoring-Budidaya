<?php

namespace Warehouse\Http\Requests;

use Illuminate\Validation\Rule;
use MasterData\Http\Requests\BaseRequest;

final class StockOpnameRequest extends BaseRequest
{
    public function rules(): array
    {
        $uuid = $this->route('stock_opname') ?? $this->route('id');

        return [
            'warehouse_id' => ['required', 'integer', 'exists:warehouses,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'opname_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('stock_opnames', 'opname_number')->ignore($uuid, 'uuid'),
            ],
            'opname_date' => ['required', 'date'],
            'status' => ['required', 'string', Rule::in(['Draft', 'Submitted', 'Approved', 'Rejected', 'Cancelled'])],
            'notes' => ['nullable', 'string'],
        ];
    }
}
