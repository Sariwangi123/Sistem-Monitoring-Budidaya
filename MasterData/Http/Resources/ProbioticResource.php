<?php

namespace MasterData\Http\Resources;

use Illuminate\Http\Request;

class ProbioticResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'probiotic_code' => $this->probiotic_code,
            'probiotic_name' => $this->probiotic_name,
            'is_active' => $this->is_active,
            ...$this->getAuditFields($request),
        ];
    }
}