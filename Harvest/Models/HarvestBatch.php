<?php

namespace Harvest\Models;

use CultureCycle\Models\CultureCycle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Shared\Support\Auditable;
use Shared\Support\HasModuleFactory;
use Shared\Support\HasUuidColumn;

class HarvestBatch extends Model
{
    use Auditable;
    use HasModuleFactory;
    use HasUuidColumn;
    use SoftDeletes;

    protected $table = 'harvest_batches';

    protected $fillable = [
        'uuid',
        'harvest_id',
        'culture_cycle_id',
        'batch_code',
        'batch_name',
        'harvest_date',
        'harvest_population',
        'gross_weight',
        'net_weight',
        'average_weight',
        'status',
        'notes',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'harvest_date' => 'date',
        'harvest_population' => 'integer',
        'gross_weight' => 'decimal:2',
        'net_weight' => 'decimal:2',
        'average_weight' => 'decimal:4',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function harvest(): BelongsTo
    {
        return $this->belongsTo(Harvest::class);
    }

    public function cultureCycle(): BelongsTo
    {
        return $this->belongsTo(CultureCycle::class);
    }

    public function qualityControls(): HasMany
    {
        return $this->hasMany(HarvestQualityControl::class);
    }

    public function grades(): HasMany
    {
        return $this->hasMany(HarvestGrade::class);
    }

    public function packings(): HasMany
    {
        return $this->hasMany(HarvestPacking::class);
    }

    public function scopeStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }
}
