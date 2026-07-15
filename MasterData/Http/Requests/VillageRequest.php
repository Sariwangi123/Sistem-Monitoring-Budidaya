<?php

namespace MasterData\Http\Requests;

use Illuminate\Validation\Rule;

class VillageRequest extends BaseRequest
{
    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'district_id' => ['required', 'integer', 'exists:districts,id'],
            'village_code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('villages', 'village_code')->ignore($id),
            ],
            'village_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }
}
