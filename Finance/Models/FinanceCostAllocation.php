<?php

namespace Finance\Models;

use CultureCycle\Models\CultureCycle;
use Harvest\Models\Harvest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Shared\Support\Auditable;
use Shared\Support\HasModuleFactory;
use Shared\Support\HasUuidColumn;

class FinanceCostAllocation extends Model
{
    use Auditable;
    use HasModuleFactory;
    use HasUuidColumn;
    use SoftDeletes;

    protected $table = 'finance_cost_allocations';

    protected $fillable = [
        'uuid',
        'ledger_id',
        'source_cost_center_id',
        'target_cost_center_id',
        'culture_cycle_id',
        'harvest_id',
        'allocation_number',
        'allocation_date',
        'allocation_method',
        'allocation_percentage',
        'allocated_amount',
        'status',
        'notes',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'allocation_date' => 'date',
        'allocation_percentage' => 'decimal:4',
        'allocated_amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function ledger(): BelongsTo
    {
        return $this->belongsTo(FinanceLedger::class, 'ledger_id');
    }

    public function sourceCostCenter(): BelongsTo
    {
        return $this->belongsTo(FinanceCostCenter::class, 'source_cost_center_id');
    }

    public function targetCostCenter(): BelongsTo
    {
        return $this->belongsTo(FinanceCostCenter::class, 'target_cost_center_id');
    }

    public function cultureCycle(): BelongsTo
    {
        return $this->belongsTo(CultureCycle::class);
    }

    public function harvest(): BelongsTo
    {
        return $this->belongsTo(Harvest::class);
    }

    public function scopeStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    public function scopeAllocationMethod(Builder $query, string $method): Builder
    {
        return $query->where('allocation_method', $method);
    }
}
