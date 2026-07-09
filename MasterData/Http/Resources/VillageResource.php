<?php

namespace MasterData\Http\Resources;

use Illuminate\Http\Request;

class VillageResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'village_code' => $this->village_code,
            'village_name' => $this->village_name,
            'district_id' => $this->district_id,
            ...$this->getAuditFields($request),
        ];
    }
}