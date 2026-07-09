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
            'medicine_type' => ['required', 'string', 'max:50'],
            'manufacturer' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }
}