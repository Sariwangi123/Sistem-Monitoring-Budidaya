<?php

namespace Modules\Roles\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Shared\Models\BaseModel;
use Shared\Support\Auditable;

class Role extends BaseModel
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

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(\Modules\Permissions\Models\Permission::class, 'role_permission')->withTimestamps();
    }
}
