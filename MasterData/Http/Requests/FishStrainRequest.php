<?php

namespace MasterData\Http\Requests;

use Illuminate\Validation\Rule;

class FishStrainRequest extends BaseRequest
{
    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'fish_species_id' => ['required', 'integer', 'exists:fish_species,id'],
            'fish_strain_code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('fish_strains', 'fish_strain_code')->ignore($id),
            ],
            'fish_strain_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }
}