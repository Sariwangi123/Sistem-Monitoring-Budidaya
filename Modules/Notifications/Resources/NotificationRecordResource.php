<?php

namespace Modules\Notifications\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class NotificationRecordResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->uuid,
            'event_name' => $this->event_name,
            'source_module' => $this->source_module,
            'notification_type' => $this->notification_type,
            'category' => $this->category,
            'priority' => $this->priority,
            'channel' => $this->channel,
            'recipient_type' => $this->recipient_type,
            'title' => $this->title,
            'message' => $this->message,
            'action_url' => $this->action_url,
            'status' => $this->status,
            'attempts' => $this->attempts,
            'max_attempts' => $this->max_attempts,
            'metadata' => $this->metadata,
            'created_at' => $this->created_at?->toISOString(),
            'read_at' => $this->read_at?->toISOString(),
            'archived_at' => $this->archived_at?->toISOString(),
            'delivered_at' => $this->delivered_at?->toISOString(),
        ];
    }
}
