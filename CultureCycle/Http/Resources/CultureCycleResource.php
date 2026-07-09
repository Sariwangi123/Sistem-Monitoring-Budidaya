<?php

namespace CultureCycle\Http\Resources;

use MasterData\Http\Resources\BaseResource;
use Illuminate\Http\Request;

class CultureCycleResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'company_id' => $this->company_id,
            'farm_id' => $this->farm_id,
            'pond_area_id' => $this->pond_area_id,
            'pond_id' => $this->pond_id,
            'fish_species_id' => $this->fish_species_id,
            'fish_strain_id' => $this->fish_strain_id,
            'supplier_id' => $this->supplier_id,
            'employee_id' => $this->employee_id,
            'cycle_code' => $this->cycle_code,
            'cycle_name' => $this->cycle_name,
            'stocking_date' => $this->stocking_date?->format('Y-m-d'),
            'estimated_harvest_date' => $this->estimated_harvest_date?->format('Y-m-d'),
            'actual_harvest_date' => $this->actual_harvest_date?->format('Y-m-d'),
            'initial_seed_quantity' => $this->initial_seed_quantity,
            'current_population' => $this->current_population,
            'initial_average_weight' => $this->initial_average_weight,
            'current_average_weight' => $this->current_average_weight,
            'current_biomass' => $this->current_biomass,
            'status' => $this->status,
            'notes' => $this->notes,
            ...$this->getAuditFields($request),
        ];
    }
}