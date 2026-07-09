<?php

namespace MasterData\Http\Requests;

use Illuminate\Validation\Rule;

class VillageRequest extends BaseRequest
{
    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'district_code' => ['required', 'string', 'exists:districts,district_code'],
            'village_code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('villages', 'village_code')->ignore($id),
            ],
            'village_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'postal_code' => ['nullable', 'string', 'max:10'],
        ];
    }
}