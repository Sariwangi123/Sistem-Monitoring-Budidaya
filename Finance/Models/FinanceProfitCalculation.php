<?php

namespace Finance\Models;

use CultureCycle\Models\CultureCycle;
use Harvest\Models\Harvest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use MasterData\Models\Company;
use MasterData\Models\Farm;
use Shared\Support\Auditable;
use Shared\Support\HasModuleFactory;
use Shared\Support\HasUuidColumn;

class FinanceProfitCalculation extends Model
{
    use Auditable;
    use HasModuleFactory;
    use HasUuidColumn;
    use SoftDeletes;

    protected $table = 'finance_profit_calculations';

    protected $fillable = [
        'uuid',
        'company_id',
        'farm_id',
        'culture_cycle_id',
        'harvest_id',
        'cost_center_id',
        'calculation_number',
        'calculation_date',
        'period_start',
        'period_end',
        'feed_cost',
        'medicine_cost',
        'labor_cost',
        'utility_cost',
        'maintenance_cost',
        'operational_cost',
        'cost_of_production',
        'total_revenue',
        'gross_profit',
        'net_profit',
        'harvest_weight',
        'cost_per_kg',
        'status',
        'notes',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'calculation_date' => 'date',
        'period_start' => 'date',
        'period_end' => 'date',
        'feed_cost' => 'decimal:2',
        'medicine_cost' => 'decimal:2',
        'labor_cost' => 'decimal:2',
        'utility_cost' => 'decimal:2',
        'maintenance_cost' => 'decimal:2',
        'operational_cost' => 'decimal:2',
        'cost_of_production' => 'decimal:2',
        'total_revenue' => 'decimal:2',
        'gross_profit' => 'decimal:2',
        'net_profit' => 'decimal:2',
        'harvest_weight' => 'decimal:2',
        'cost_per_kg' => 'decimal:4',
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

    public function harvest(): BelongsTo
    {
        return $this->belongsTo(Harvest::class);
    }

    public function costCenter(): BelongsTo
    {
        return $this->belongsTo(FinanceCostCenter::class, 'cost_center_id');
    }

    public function scopeStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    public function scopePeriodBetween(Builder $query, string $startDate, string $endDate): Builder
    {
        return $query
            ->whereDate('period_start', '>=', $startDate)
            ->whereDate('period_end', '<=', $endDate);
    }
}
