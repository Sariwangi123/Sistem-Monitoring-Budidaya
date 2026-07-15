<?php

namespace Modules\Notifications\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Shared\Models\BaseModel;

final class NotificationHistory extends BaseModel
{
    protected $fillable = [
        'uuid',
        'notification_record_id',
        'event_name',
        'channel',
        'recipient_type',
        'recipient_id',
        'status',
        'attempt',
        'metadata',
        'delivered_at',
        'read_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'delivered_at' => 'datetime',
        'read_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function record(): BelongsTo
    {
        return $this->belongsTo(NotificationRecord::class, 'notification_record_id');
    }
}
