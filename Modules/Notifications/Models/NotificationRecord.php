<?php

namespace Modules\Notifications\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Shared\Models\BaseModel;
use Shared\Support\Auditable;

final class NotificationRecord extends BaseModel
{
    use Auditable;

    protected $fillable = [
        'uuid',
        'event_name',
        'source_module',
        'correlation_id',
        'notification_type',
        'category',
        'priority',
        'channel',
        'recipient_type',
        'recipient_id',
        'title',
        'message',
        'action_url',
        'status',
        'attempts',
        'max_attempts',
        'last_error',
        'metadata',
        'delivered_at',
        'read_at',
        'archived_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'metadata' => 'array',
        'delivered_at' => 'datetime',
        'read_at' => 'datetime',
        'archived_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function histories(): HasMany
    {
        return $this->hasMany(NotificationHistory::class);
    }
}
