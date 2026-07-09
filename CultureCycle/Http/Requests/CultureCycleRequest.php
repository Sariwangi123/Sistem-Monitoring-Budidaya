<?php

namespace CultureCycle\Http\Requests;

use MasterData\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class CultureCycleRequest extends BaseRequest
{
    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'company_id' => ['required', 'string', 'exists:companies,id'],
            'farm_id' => ['required', 'string', 'exists:farms,id'],
            'pond_area_id' => ['required', 'string', 'exists:pond_areas,id'],
            'pond_id' => ['required', 'string', 'exists:ponds,id'],
            'fish_species_id' => ['required', 'string', 'exists:fish_species,id'],
            'fish_strain_id' => ['nullable', 'string', 'exists:fish_strains,id'],
            'supplier_id' => ['nullable', 'string', 'exists:suppliers,id'],
            'employee_id' => ['nullable', 'string', 'exists:employees,id'],
            'cycle_code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('culture_cycles', 'cycle_code')->ignore($id),
            ],
            'cycle_name' => ['required', 'string', 'max:255'],
            'stocking_date' => ['required', 'date'],
            'estimated_harvest_date' => ['nullable', 'date', 'after_or_equal:stocking_date'],
            'initial_seed_quantity' => ['required', 'integer', 'min:1'],
            'initial_average_weight' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'string', Rule::in(['active', 'completed', 'cancelled'])],
            'notes' => ['nullable', 'string'],
        ];
    }
}