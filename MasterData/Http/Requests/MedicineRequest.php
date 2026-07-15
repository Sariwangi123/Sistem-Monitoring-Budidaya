<?php

namespace MasterData\Http\Requests;

use Illuminate\Validation\Rule;

class MedicineRequest extends BaseRequest
{
    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'medicine_code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('medicines', 'medicine_code')->ignore($id),
            ],
            'medicine_name' => ['required', 'string', 'max:255'],
            'active_ingredient' => ['nullable', 'string', 'max:255'],
            'manufacturer' => ['nullable', 'string', 'max:255'],
            'packaging_size' => ['nullable', 'numeric', 'min:0'],
            'packaging_unit_id' => ['nullable', 'integer', 'exists:units,id'],
            'description' => ['nullable', 'string'],
        ];
    }
}
