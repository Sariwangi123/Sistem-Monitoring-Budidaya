<?php

namespace MasterData\Http\Requests;

use Illuminate\Validation\Rule;

class VitaminRequest extends BaseRequest
{
    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'vitamin_code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('vitamins', 'vitamin_code')->ignore($id),
            ],
            'vitamin_name' => ['required', 'string', 'max:255'],
            'composition' => ['nullable', 'string', 'max:255'],
            'manufacturer' => ['nullable', 'string', 'max:255'],
            'packaging_size' => ['nullable', 'numeric', 'min:0'],
            'packaging_unit_id' => ['nullable', 'integer', 'exists:units,id'],
            'description' => ['nullable', 'string'],
        ];
    }
}