<?php

namespace Modules\Notifications\Models;

use Shared\Models\BaseModel;
use Shared\Support\Auditable;

class NotificationTemplate extends BaseModel
{
    use Auditable;

    protected $fillable = [
        'uuid',
        'channel',
        'name',
        'subject',
        'body',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
