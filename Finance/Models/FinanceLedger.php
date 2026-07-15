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
use Shared\Support\Auditable;
use Shared\Support\HasModuleFactory;
use Shared\Support\HasUuidColumn;

class FinanceLedger extends Model
{
    use Auditable;
    use HasModuleFactory;
    use HasUuidColumn;
    use SoftDeletes;

    protected $table = 'finance_ledgers';

    protected $fillable = [
        'uuid',
        'company_id',
        'farm_id',
        'culture_cycle_id',
        'cost_center_id',
        'expense_id',
        'revenue_id',
        'journal_id',
        'ledger_number',
        'document_number',
        'ledger_date',
        'ledger_type',
        'account_code',
        'account_name',
        'debit_amount',
        'credit_amount',
        'balance_amount',
        'currency',
        'source_type',
        'source_uuid',
        'posted_at',
        'status',
        'description',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'ledger_date' => 'date',
        'debit_amount' => 'decimal:2',
        'credit_amount' => 'decimal:2',
        'balance_amount' => 'decimal:2',
        'posted_at' => 'datetime',
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

    public function expense(): BelongsTo
    {
        return $this->belongsTo(FinanceExpense::class, 'expense_id');
    }

    public function revenue(): BelongsTo
    {
        return $this->belongsTo(FinanceRevenue::class, 'revenue_id');
    }

    public function journal(): BelongsTo
    {
        return $this->belongsTo(FinanceJournal::class, 'journal_id');
    }

    public function entries(): HasMany
    {
        return $this->hasMany(FinanceJournalEntry::class, 'ledger_id');
    }

    public function costAllocations(): HasMany
    {
        return $this->hasMany(FinanceCostAllocation::class, 'ledger_id');
    }

    public function scopeStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    public function scopeLedgerType(Builder $query, string $type): Builder
    {
        return $query->where('ledger_type', $type);
    }

    public function scopeLedgerDateBetween(Builder $query, string $startDate, string $endDate): Builder
    {
        return $query->whereBetween('ledger_date', [$startDate, $endDate]);
    }

    public function scopePosted(Builder $query): Builder
    {
        return $query->whereNotNull('posted_at');
    }
}
