<?php

namespace MasterData\Http\Requests;

use Illuminate\Validation\Rule;

class PondRequest extends BaseRequest
{
    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'pond_area_id' => ['required', 'integer', 'exists:pond_areas,id'],
            'pond_code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('ponds', 'pond_code')->ignore($id),
            ],
            'pond_name' => ['required', 'string', 'max:255'],
            'depth' => ['nullable', 'numeric', 'min:0'],
            'area_size' => ['nullable', 'numeric', 'min:0'],
            'volume' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
        ];
    }
}
