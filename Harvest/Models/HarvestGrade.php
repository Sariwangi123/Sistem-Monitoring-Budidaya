<?php

namespace Harvest\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Shared\Support\Auditable;
use Shared\Support\HasModuleFactory;
use Shared\Support\HasUuidColumn;

class HarvestGrade extends Model
{
    use Auditable;
    use HasModuleFactory;
    use HasUuidColumn;
    use SoftDeletes;

    protected $table = 'harvest_grades';

    protected $fillable = [
        'uuid',
        'harvest_id',
        'harvest_batch_id',
        'grade_code',
        'grade_name',
        'fish_count',
        'total_weight',
        'average_weight',
        'quality_status',
        'notes',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'fish_count' => 'integer',
        'total_weight' => 'decimal:2',
        'average_weight' => 'decimal:4',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function harvest(): BelongsTo
    {
        return $this->belongsTo(Harvest::class);
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(HarvestBatch::class, 'harvest_batch_id');
    }

    public function packings(): HasMany
    {
        return $this->hasMany(HarvestPacking::class);
    }

    public function scopeQualityStatus(Builder $query, string $status): Builder
    {
        return $query->where('quality_status', $status);
    }
}
