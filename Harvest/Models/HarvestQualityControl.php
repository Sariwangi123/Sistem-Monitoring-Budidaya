<?php

namespace Harvest\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Users\Models\User;
use Shared\Support\Auditable;
use Shared\Support\HasModuleFactory;
use Shared\Support\HasUuidColumn;

class HarvestQualityControl extends Model
{
    use Auditable;
    use HasModuleFactory;
    use HasUuidColumn;
    use SoftDeletes;

    protected $table = 'harvest_quality_controls';

    protected $fillable = [
        'uuid',
        'harvest_id',
        'harvest_batch_id',
        'qc_user_id',
        'qc_date',
        'average_weight',
        'fish_size',
        'fish_condition',
        'damage_rate',
        'qc_status',
        'qc_notes',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'qc_date' => 'date',
        'average_weight' => 'decimal:4',
        'damage_rate' => 'decimal:4',
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

    public function qcUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'qc_user_id');
    }

    public function scopeStatus(Builder $query, string $status): Builder
    {
        return $query->where('qc_status', $status);
    }
}
