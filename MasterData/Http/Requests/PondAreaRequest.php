<?php

namespace MasterData\Http\Requests;

use Illuminate\Validation\Rule;

class PondAreaRequest extends BaseRequest
{
    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'farm_id' => ['required', 'integer', 'exists:farms,id'],
            'pond_area_code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('pond_areas', 'pond_area_code')->ignore($id),
            ],
            'pond_area_name' => ['required', 'string', 'max:255'],
            'area_size' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
        ];
    }
}