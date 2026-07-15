<?php

namespace Modules\Notifications\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Users\Models\User;
use Shared\Models\BaseModel;
use Shared\Support\Auditable;

final class NotificationPreference extends BaseModel
{
    use Auditable;

    protected $fillable = [
        'uuid',
        'user_id',
        'in_app_enabled',
        'reminder_enabled',
        'sound_enabled',
        'email_enabled',
        'whatsapp_enabled',
        'desktop_notification_enabled',
        'metadata',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'in_app_enabled' => 'boolean',
        'reminder_enabled' => 'boolean',
        'sound_enabled' => 'boolean',
        'email_enabled' => 'boolean',
        'whatsapp_enabled' => 'boolean',
        'desktop_notification_enabled' => 'boolean',
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
