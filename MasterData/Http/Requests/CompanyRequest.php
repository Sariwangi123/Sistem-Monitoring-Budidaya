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
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'website' => ['nullable', 'url', 'max:255'],
            'tax_number' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string'],
            'province_id' => ['nullable', 'integer', 'exists:provinces,id'],
            'city_id' => ['nullable', 'integer', 'exists:cities,id'],
            'district_id' => ['nullable', 'integer', 'exists:districts,id'],
            'village_id' => ['nullable', 'integer', 'exists:villages,id'],
            'postal_code' => ['nullable', 'string', 'max:10'],
        ];
    }
}
