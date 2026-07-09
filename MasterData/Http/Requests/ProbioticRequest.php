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
            'probiotic_type' => ['required', 'string', 'max:50'],
            'manufacturer' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }
}