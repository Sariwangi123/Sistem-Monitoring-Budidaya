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
            'activity_category_id' => $this->activity_category_id,
            'event_code' => $this->event_code,
            'activity_name' => $this->activity_name,
            'icon' => $this->icon,
            'color' => $this->color,
            'is_manual' => $this->is_manual,
            'is_system' => $this->is_system,
            'status' => $this->status,
            'description' => $this->description,
            'category' => ActivityCategoryResource::make($this->whenLoaded('category')),
            ...$this->getAuditFields($request),
        ];
    }
}
