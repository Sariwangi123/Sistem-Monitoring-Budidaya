<?php

namespace Finance\Models;

use CultureCycle\Models\CultureCycle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use MasterData\Models\Company;
use MasterData\Models\Farm;
use Shared\Support\Auditable;
use Shared\Support\HasModuleFactory;
use Shared\Support\HasUuidColumn;

class FinanceFinancialSummary extends Model
{
    use Auditable;
    use HasModuleFactory;
    use HasUuidColumn;
    use SoftDeletes;

    protected $table = 'finance_financial_summaries';

    protected $fillable = [
        'uuid',
        'company_id',
        'farm_id',
        'culture_cycle_id',
        'cost_center_id',
        'summary_number',
        'summary_type',
        'period_start',
        'period_end',
        'total_expense',
        'total_revenue',
        'cost_of_production',
        'gross_profit',
        'net_profit',
        'profit_margin',
        'status',
        'notes',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date',
        'total_expense' => 'decimal:2',
        'total_revenue' => 'decimal:2',
        'cost_of_production' => 'decimal:2',
        'gross_profit' => 'decimal:2',
        'net_profit' => 'decimal:2',
        'profit_margin' => 'decimal:4',
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

    public function cultureCycle(): BelongsTo
    {
        return $this->belongsTo(CultureCycle::class);
    }

    public function costCenter(): BelongsTo
    {
        return $this->belongsTo(FinanceCostCenter::class, 'cost_center_id');
    }

    public function scopeStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    public function scopeSummaryType(Builder $query, string $type): Builder
    {
        return $query->where('summary_type', $type);
    }

    public function scopePeriodBetween(Builder $query, string $startDate, string $endDate): Builder
    {
        return $query
            ->whereDate('period_start', '>=', $startDate)
            ->whereDate('period_end', '<=', $endDate);
    }
}
