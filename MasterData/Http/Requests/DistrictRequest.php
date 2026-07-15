<?php

namespace MasterData\Http\Requests;

use Illuminate\Validation\Rule;

class DistrictRequest extends BaseRequest
{
    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'city_id' => ['required', 'integer', 'exists:cities,id'],
            'district_code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('districts', 'district_code')->ignore($id),
            ],
            'district_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }
}
