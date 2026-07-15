<?php

namespace Modules\Notifications\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class NotificationOverviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return $this->resource;
    }

    public function with(Request $request): array
    {
        return [
            'success' => true,
            'message' => 'Notification foundation overview retrieved.',
            'meta' => [
                'module' => 'notification',
                'part' => 'foundation',
                'read_only_business_module' => true,
                'event_driven_ready' => true,
                'delivery_engine_enabled' => true,
                'external_channel_delivery_enabled' => false,
            ],
        ];
    }
}
