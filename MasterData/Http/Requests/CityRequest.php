<?php

namespace MasterData\Http\Requests;

use Illuminate\Validation\Rule;

class CityRequest extends BaseRequest
{
    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'province_code' => ['required', 'string', 'exists:provinces,province_code'],
            'city_code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('cities', 'city_code')->ignore($id),
            ],
            'city_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }
}