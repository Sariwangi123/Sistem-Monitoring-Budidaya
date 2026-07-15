<?php

namespace Modules\Notifications\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class NotificationHistoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->uuid,
            'notification_id' => $this->record?->uuid,
            'event_name' => $this->event_name,
            'channel' => $this->channel,
            'recipient_type' => $this->recipient_type,
            'status' => $this->status,
            'attempt' => $this->attempt,
            'metadata' => $this->metadata,
            'delivered_at' => $this->delivered_at?->toISOString(),
            'read_at' => $this->read_at?->toISOString(),
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
