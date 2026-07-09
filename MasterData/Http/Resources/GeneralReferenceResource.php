<?php

namespace MasterData\Http\Resources;

use Illuminate\Http\Request;

class GeneralReferenceResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'reference_type' => $this->reference_type,
            'reference_code' => $this->reference_code,
            'reference_name' => $this->reference_name,
            'reference_value' => $this->reference_value,
            'sequence' => $this->sequence,
            'is_active' => $this->is_active,
            ...$this->getAuditFields($request),
        ];
    }
}