<?php

namespace Activities\Http\Resources;

use MasterData\Http\Resources\BaseResource;
use Illuminate\Http\Request;

class ActivityResource extends BaseResource
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
            'culture_cycle_id' => $this->culture_cycle_id,
            'activity_type_id' => $this->activity_type_id,
            'user_id' => $this->user_id,
            'activity_date' => $this->activity_date?->format('Y-m-d'),
            'activity_time' => $this->activity_time,
            'event_code' => $this->event_code,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'reference_type' => $this->reference_type,
            'reference_uuid' => $this->reference_uuid,
            'metadata' => $this->metadata,
            ...$this->getAuditFields($request),
        ];
    }
}