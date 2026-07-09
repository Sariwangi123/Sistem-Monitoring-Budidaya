<?php

namespace MasterData\Http\Resources;

use Illuminate\Http\Request;

class FeedCategoryResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'feed_category_code' => $this->feed_category_code,
            'feed_category_name' => $this->feed_category_name,
            'is_active' => $this->is_active,
            ...$this->getAuditFields($request),
        ];
    }
}