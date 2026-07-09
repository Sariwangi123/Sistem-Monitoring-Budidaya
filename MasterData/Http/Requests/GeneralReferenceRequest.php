<?php

namespace MasterData\Http\Requests;

use Illuminate\Validation\Rule;

class GeneralReferenceRequest extends BaseRequest
{
    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'reference_code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('general_references', 'reference_code')->ignore($id),
            ],
            'reference_name' => ['required', 'string', 'max:255'],
            'reference_group' => ['required', 'string', 'max:100'],
            'reference_value' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
            'description' => ['nullable', 'string'],
        ];
    }
}