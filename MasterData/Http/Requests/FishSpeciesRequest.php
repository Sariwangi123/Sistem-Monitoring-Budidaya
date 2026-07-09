<?php

namespace MasterData\Http\Requests;

use Illuminate\Validation\Rule;

class FishSpeciesRequest extends BaseRequest
{
    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'fish_species_code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('fish_species', 'fish_species_code')->ignore($id),
            ],
            'fish_species_name' => ['required', 'string', 'max:255'],
            'scientific_name' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }
}