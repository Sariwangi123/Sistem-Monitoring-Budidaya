<?php

namespace Modules\Permissions\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Shared\Models\BaseModel;
use Shared\Support\Auditable;

class Permission extends BaseModel
{
    use Auditable;

    protected $fillable = [
        'uuid',
        'name',
        'slug',
        'description',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(\Modules\Roles\Models\Role::class)->withTimestamps();
    }
}
