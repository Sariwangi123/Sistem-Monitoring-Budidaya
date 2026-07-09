<?php

namespace MasterData\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Shared\Support\Auditable;
use Shared\Support\HasUuidColumn;

class PondArea extends Model
{
    use Auditable;
    use HasUuidColumn;
    use SoftDeletes;

    protected $table = 'pond_areas';

    protected $fillable = [
        'uuid',
        'farm_id',
        'pond_area_code',
        'pond_area_name',
        'area_size',
        'description',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'area_size' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class);
    }

    public function ponds(): HasMany
    {
        return $this->hasMany(Pond::class);
    }
}