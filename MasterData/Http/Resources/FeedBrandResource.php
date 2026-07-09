<?php

namespace MasterData\Http\Resources;

use Illuminate\Http\Request;

class FeedBrandResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'feed_brand_code' => $this->feed_brand_code,
            'feed_brand_name' => $this->feed_brand_name,
            'is_active' => $this->is_active,
            ...$this->getAuditFields($request),
        ];
    }
}