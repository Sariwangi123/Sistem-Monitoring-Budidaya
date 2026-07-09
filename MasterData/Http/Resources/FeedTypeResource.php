<?php

namespace MasterData\Http\Resources;

use Illuminate\Http\Request;

class FeedTypeResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'feed_type_code' => $this->feed_type_code,
            'feed_type_name' => $this->feed_type_name,
            'feed_category_id' => $this->feed_category_id,
            'feed_brand_id' => $this->feed_brand_id,
            'package_weight' => $this->package_weight,
            'weight_unit_id' => $this->weight_unit_id,
            'is_active' => $this->is_active,
            ...$this->getAuditFields($request),
        ];
    }
}