<?php

namespace Modules\Settings\Models;

use Shared\Models\BaseModel;
use Shared\Support\Auditable;

class GlobalSetting extends BaseModel
{
    use Auditable;

    protected $fillable = [
        'uuid',
        'key',
        'value',
        'type',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'value' => 'array',
    ];
}
