<?php

namespace MasterData\Http\Requests;

use Illuminate\Validation\Rule;

class ProbioticRequest extends BaseRequest
{
    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'probiotic_code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('probiotics', 'probiotic_code')->ignore($id),
            ],
            'probiotic_name' => ['required', 'string', 'max:255'],
            'bacterial_strain' => ['nullable', 'string', 'max:255'],
            'manufacturer' => ['nullable', 'string', 'max:255'],
            'packaging_size' => ['nullable', 'numeric', 'min:0'],
            'packaging_unit_id' => ['nullable', 'integer', 'exists:units,id'],
            'description' => ['nullable', 'string'],
        ];
    }
}
