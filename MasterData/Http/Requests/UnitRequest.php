<?php

namespace MasterData\Http\Requests;

use Illuminate\Validation\Rule;

class UnitRequest extends BaseRequest
{
    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'unit_category' => ['required', 'string', 'max:50'],
            'unit_code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('units', 'unit_code')->ignore($id),
            ],
            'unit_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }
}