<?php

namespace MasterData\Http\Requests;

use Illuminate\Validation\Rule;

class FarmRequest extends BaseRequest
{
    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'company_code' => ['required', 'string', 'exists:companies,company_code'],
            'farm_code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('farms', 'farm_code')->ignore($id),
            ],
            'farm_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'province_code' => ['nullable', 'string', 'exists:provinces,province_code'],
            'city_code' => ['nullable', 'string', 'exists:cities,city_code'],
            'district_code' => ['nullable', 'string', 'exists:districts,district_code'],
            'village_code' => ['nullable', 'string', 'exists:villages,village_code'],
            'postal_code' => ['nullable', 'string', 'max:10'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'is_active' => ['boolean'],
        ];
    }
}