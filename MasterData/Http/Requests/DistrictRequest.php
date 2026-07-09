<?php

namespace MasterData\Http\Requests;

use Illuminate\Validation\Rule;

class DistrictRequest extends BaseRequest
{
    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'city_code' => ['required', 'string', 'exists:cities,city_code'],
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