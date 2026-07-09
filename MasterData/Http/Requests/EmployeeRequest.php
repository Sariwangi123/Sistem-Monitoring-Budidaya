<?php

namespace MasterData\Http\Requests;

use Illuminate\Validation\Rule;

class EmployeeRequest extends BaseRequest
{
    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'employee_code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('employees', 'employee_code')->ignore($id),
            ],
            'employee_name' => ['required', 'string', 'max:255'],
            'identity_number' => ['nullable', 'string', 'max:50'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'birth_date' => ['nullable', 'date'],
            'gender' => ['nullable', 'string', 'max:1', Rule::in(['L', 'P'])],
            'address' => ['nullable', 'string'],
            'province_id' => ['nullable', 'integer', 'exists:provinces,id'],
            'city_id' => ['nullable', 'integer', 'exists:cities,id'],
            'district_id' => ['nullable', 'integer', 'exists:districts,id'],
            'village_id' => ['nullable', 'integer', 'exists:villages,id'],
            'postal_code' => ['nullable', 'string', 'max:10'],
            'position' => ['nullable', 'string', 'max:100'],
            'department' => ['nullable', 'string', 'max:100'],
            'hire_date' => ['nullable', 'date'],
            'is_active' => ['boolean'],
            'notes' => ['nullable', 'string'],
        ];
    }
}