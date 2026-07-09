<?php

namespace MasterData\Http\Resources;

use Illuminate\Http\Request;

class FishStrainResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'fish_strain_code' => $this->fish_strain_code,
            'fish_strain_name' => $this->fish_strain_name,
            'fish_species_id' => $this->fish_species_id,
            'is_active' => $this->is_active,
            ...$this->getAuditFields($request),
        ];
    }
}