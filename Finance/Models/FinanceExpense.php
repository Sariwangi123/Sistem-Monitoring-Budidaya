<?php

namespace Finance\Models;

use Activities\Models\Activity;
use CultureCycle\Models\CultureCycle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use MasterData\Models\Company;
use MasterData\Models\Farm;
use MasterData\Models\GeneralReference;
use MasterData\Models\Supplier;
use Modules\Users\Models\User;
use Shared\Support\Auditable;
use Shared\Support\HasModuleFactory;
use Shared\Support\HasUuidColumn;
use Warehouse\Models\InventoryMovement;

class FinanceExpense extends Model
{
    use Auditable;
    use HasModuleFactory;
    use HasUuidColumn;
    use SoftDeletes;

    protected $table = 'finance_expenses';

    protected $fillable = [
        'uuid',
        'company_id',
        'farm_id',
        'culture_cycle_id',
        'cost_center_id',
        'expense_category_id',
        'supplier_id',
        'activity_id',
        'inventory_movement_id',
        'user_id',
        'expense_number',
        'document_number',
        'expense_date',
        'expense_type',
        'payment_method',
        'amount',
        'tax_amount',
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
        'expense_date' => 'date',
        'amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
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
        return $this->belongsTo(GeneralReference::class, 'expense_category_id');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    public function inventoryMovement(): BelongsTo
    {
        return $this->belongsTo(InventoryMovement::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ledgers(): HasMany
    {
        return $this->hasMany(FinanceLedger::class, 'expense_id');
    }

    public function scopeStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    public function scopeExpenseType(Builder $query, string $type): Builder
    {
        return $query->where('expense_type', $type);
    }

    public function scopeExpenseDateBetween(Builder $query, string $startDate, string $endDate): Builder
    {
        return $query->whereBetween('expense_date', [$startDate, $endDate]);
    }
}
