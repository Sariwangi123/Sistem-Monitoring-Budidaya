<?php

namespace Modules\Notifications\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class NotificationApiResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return $this->resource;
    }

    public function with(Request $request): array
    {
        return [
            'success' => true,
            'message' => $this->resource['message'] ?? 'Success',
            'meta' => [
                'module' => 'notification',
                'external_channel_delivery_enabled' => false,
                'business_event_api_enabled' => false,
            ],
        ];
    }
}
