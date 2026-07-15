<?php

namespace MasterData\Http\Requests;

use Illuminate\Validation\Rule;

class FarmRequest extends BaseRequest
{
    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'company_id' => ['required', 'integer', 'exists:companies,id'],
            'farm_code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('farms', 'farm_code')->ignore($id),
            ],
            'farm_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ];
    }
}
