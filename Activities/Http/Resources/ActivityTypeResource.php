<?php

namespace Activities\Http\Resources;

use MasterData\Http\Resources\BaseResource;
use Illuminate\Http\Request;

class ActivityTypeResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'category_id' => $this->category_id,
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'icon' => $this->icon,
            'color' => $this->color,
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
            'category' => ActivityCategoryResource::make($this->whenLoaded('category')),
            ...$this->getAuditFields($request),
        ];
    }
}