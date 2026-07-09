<?php

namespace MasterData\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Shared\Support\Auditable;
use Shared\Support\HasUuidColumn;

class Pond extends Model
{
    use Auditable;
    use HasUuidColumn;
    use SoftDeletes;

    protected $table = 'ponds';

    protected $fillable = [
        'uuid',
        'pond_area_id',
        'pond_code',
        'pond_name',
        'area_size',
        'depth',
        'volume',
        'description',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'area_size' => 'decimal:2',
        'depth' => 'decimal:2',
        'volume' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function pondArea(): BelongsTo
    {
        return $this->belongsTo(PondArea::class);
    }
}