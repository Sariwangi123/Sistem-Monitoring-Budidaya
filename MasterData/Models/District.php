<?php

namespace MasterData\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Shared\Support\Auditable;
use Shared\Support\HasUuidColumn;

class District extends Model
{
    use Auditable;
    use HasUuidColumn;
    use SoftDeletes;

    protected $table = 'districts';

    protected $fillable = [
        'uuid',
        'city_id',
        'district_code',
        'district_name',
        'description',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function villages(): HasMany
    {
        return $this->hasMany(Village::class);
    }
}