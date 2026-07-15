<?php

namespace Finance\Models;

use CultureCycle\Models\CultureCycle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use MasterData\Models\Company;
use MasterData\Models\Farm;
use MasterData\Models\Pond;
use Shared\Support\Auditable;
use Shared\Support\HasModuleFactory;
use Shared\Support\HasUuidColumn;

class FinanceCostCenter extends Model
{
    use Auditable;
    use HasModuleFactory;
    use HasUuidColumn;
    use SoftDeletes;

    protected $table = 'finance_cost_centers';

    protected $fillable = [
        'uuid',
        'company_id',
        'farm_id',
        'pond_id',
        'culture_cycle_id',
        'cost_center_code',
        'cost_center_name',
        'cost_center_type',
        'effective_from',
        'effective_to',
        'status',
        'description',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'effective_from' => 'date',
        'effective_to' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class);
    }

    public function pond(): BelongsTo
    {
        return $this->belongsTo(Pond::class);
    }

    public function cultureCycle(): BelongsTo
    {
        return $this->belongsTo(CultureCycle::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(FinanceExpense::class, 'cost_center_id');
    }

    public function revenues(): HasMany
    {
        return $this->hasMany(FinanceRevenue::class, 'cost_center_id');
    }

    public function ledgers(): HasMany
    {
        return $this->hasMany(FinanceLedger::class, 'cost_center_id');
    }

    public function journalEntries(): HasMany
    {
        return $this->hasMany(FinanceJournalEntry::class, 'cost_center_id');
    }

    public function sourceCostAllocations(): HasMany
    {
        return $this->hasMany(FinanceCostAllocation::class, 'source_cost_center_id');
    }

    public function targetCostAllocations(): HasMany
    {
        return $this->hasMany(FinanceCostAllocation::class, 'target_cost_center_id');
    }

    public function profitCalculations(): HasMany
    {
        return $this->hasMany(FinanceProfitCalculation::class, 'cost_center_id');
    }

    public function financialSummaries(): HasMany
    {
        return $this->hasMany(FinanceFinancialSummary::class, 'cost_center_id');
    }

    public function scopeStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    public function scopeCostCenterType(Builder $query, string $type): Builder
    {
        return $query->where('cost_center_type', $type);
    }
}
