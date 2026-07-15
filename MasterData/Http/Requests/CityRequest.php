<?php

namespace MasterData\Http\Requests;

use Illuminate\Validation\Rule;

class CityRequest extends BaseRequest
{
    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'province_id' => ['required', 'integer', 'exists:provinces,id'],
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
