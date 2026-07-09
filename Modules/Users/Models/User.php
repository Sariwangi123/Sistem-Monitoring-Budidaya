<?php

namespace Modules\Users\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Shared\Support\Auditable;
use Shared\Support\HasUuidColumn;

class User extends Authenticatable
{
    use Auditable;
    use HasApiTokens;
    use HasUuidColumn;
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(\Modules\Roles\Models\Role::class)->withTimestamps();
    }

    public function hasPermission(string $permission): bool
    {
        return $this->roles()
            ->whereHas('permissions', fn ($query) => $query->where('slug', $permission))
            ->exists();
    }
}
