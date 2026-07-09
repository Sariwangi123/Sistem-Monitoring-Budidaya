<?php

namespace MasterData\Http\Requests;

use Illuminate\Validation\Rule;

class CompanyRequest extends BaseRequest
{
    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'company_code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('companies', 'company_code')->ignore($id),
            ],
            'company_name' => ['required', 'string', 'max:255'],
            'company_type' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'website' => ['nullable', 'url', 'max:255'],
            'tax_number' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string'],
            'province_code' => ['nullable', 'string', 'exists:provinces,province_code'],
            'city_code' => ['nullable', 'string', 'exists:cities,city_code'],
            'district_code' => ['nullable', 'string', 'exists:districts,district_code'],
            'village_code' => ['nullable', 'string', 'exists:villages,village_code'],
            'postal_code' => ['nullable', 'string', 'max:10'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'is_active' => ['boolean'],
        ];
    }
}