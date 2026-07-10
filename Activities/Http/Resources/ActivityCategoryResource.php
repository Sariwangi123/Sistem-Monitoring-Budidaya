<?php

namespace Activities\Http\Resources;

use MasterData\Http\Resources\BaseResource;
use Illuminate\Http\Request;

class ActivityCategoryResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'category_code' => $this->category_code,
            'category_name' => $this->category_name,
            'description' => $this->description,
            'status' => $this->status,
            ...$this->getAuditFields($request),
        ];
    }
}
