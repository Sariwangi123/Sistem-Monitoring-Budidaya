<?php

namespace Harvest\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Users\Models\User;
use Shared\Support\Auditable;
use Shared\Support\HasModuleFactory;
use Shared\Support\HasUuidColumn;

class HarvestPacking extends Model
{
    use Auditable;
    use HasModuleFactory;
    use HasUuidColumn;
    use SoftDeletes;

    protected $table = 'harvest_packings';

    protected $fillable = [
        'uuid',
        'harvest_id',
        'harvest_batch_id',
        'harvest_grade_id',
        'operator_user_id',
        'packing_code',
        'packing_date',
        'package_type',
        'package_quantity',
        'net_weight',
        'gross_weight',
        'status',
        'notes',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'packing_date' => 'date',
        'package_quantity' => 'integer',
        'net_weight' => 'decimal:2',
        'gross_weight' => 'decimal:2',
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

    public function grade(): BelongsTo
    {
        return $this->belongsTo(HarvestGrade::class, 'harvest_grade_id');
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'operator_user_id');
    }

    public function deliveries(): HasMany
    {
        return $this->hasMany(HarvestDelivery::class);
    }

    public function scopeStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }
}
