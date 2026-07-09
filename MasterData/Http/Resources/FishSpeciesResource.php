<?php

namespace MasterData\Http\Resources;

use Illuminate\Http\Request;

class FishSpeciesResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'fish_species_code' => $this->fish_species_code,
            'fish_species_name' => $this->fish_species_name,
            'scientific_name' => $this->scientific_name,
            'is_active' => $this->is_active,
            ...$this->getAuditFields($request),
        ];
    }
}