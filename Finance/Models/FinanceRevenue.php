<?php

namespace Finance\Models;

use CultureCycle\Models\CultureCycle;
use Harvest\Models\Harvest;
use Harvest\Models\HarvestDelivery;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use MasterData\Models\Company;
use MasterData\Models\Customer;
use MasterData\Models\Farm;
use MasterData\Models\GeneralReference;
use Modules\Users\Models\User;
use Shared\Support\Auditable;
use Shared\Support\HasModuleFactory;
use Shared\Support\HasUuidColumn;

class FinanceRevenue extends Model
{
    use Auditable;
    use HasModuleFactory;
    use HasUuidColumn;
    use SoftDeletes;

    protected $table = 'finance_revenues';

    protected $fillable = [
        'uuid',
        'company_id',
        'farm_id',
        'culture_cycle_id',
        'cost_center_id',
        'revenue_category_id',
        'harvest_id',
        'harvest_delivery_id',
        'customer_id',
        'user_id',
        'revenue_number',
        'document_number',
        'revenue_date',
        'revenue_type',
        'quantity',
        'unit_price',
        'amount',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'currency',
        'source_type',
        'source_uuid',
        'status',
        'notes',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'revenue_date' => 'date',
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
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

    public function category(): BelongsTo
    {
        return $this->belongsTo(GeneralReference::class, 'revenue_category_id');
    }

    public function harvest(): BelongsTo
    {
        return $this->belongsTo(Harvest::class);
    }

    public function harvestDelivery(): BelongsTo
    {
        return $this->belongsTo(HarvestDelivery::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ledgers(): HasMany
    {
        return $this->hasMany(FinanceLedger::class, 'revenue_id');
    }

    public function scopeStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    public function scopeRevenueType(Builder $query, string $type): Builder
    {
        return $query->where('revenue_type', $type);
    }

    public function scopeRevenueDateBetween(Builder $query, string $startDate, string $endDate): Builder
    {
        return $query->whereBetween('revenue_date', [$startDate, $endDate]);
    }
}
