<?php

namespace MasterData\Http\Requests;

use Illuminate\Validation\Rule;

class CustomerRequest extends BaseRequest
{
    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'customer_code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('customers', 'customer_code')->ignore($id),
            ],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_type' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'tax_number' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string'],
            'province_id' => ['nullable', 'integer', 'exists:provinces,id'],
            'city_id' => ['nullable', 'integer', 'exists:cities,id'],
            'district_id' => ['nullable', 'integer', 'exists:districts,id'],
            'village_id' => ['nullable', 'integer', 'exists:villages,id'],
            'postal_code' => ['nullable', 'string', 'max:10'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'payment_terms' => ['nullable', 'string', 'max:100'],
            'credit_limit' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}