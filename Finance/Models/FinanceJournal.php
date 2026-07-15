<?php

namespace Finance\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use MasterData\Models\Company;
use MasterData\Models\Farm;
use Modules\Users\Models\User;
use Shared\Support\Auditable;
use Shared\Support\HasModuleFactory;
use Shared\Support\HasUuidColumn;

class FinanceJournal extends Model
{
    use Auditable;
    use HasModuleFactory;
    use HasUuidColumn;
    use SoftDeletes;

    protected $table = 'finance_journals';

    protected $fillable = [
        'uuid',
        'company_id',
        'farm_id',
        'user_id',
        'journal_number',
        'document_number',
        'journal_date',
        'journal_type',
        'total_debit',
        'total_credit',
        'source_type',
        'source_uuid',
        'status',
        'description',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'journal_date' => 'date',
        'total_debit' => 'decimal:2',
        'total_credit' => 'decimal:2',
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ledgers(): HasMany
    {
        return $this->hasMany(FinanceLedger::class, 'journal_id');
    }

    public function entries(): HasMany
    {
        return $this->hasMany(FinanceJournalEntry::class, 'journal_id');
    }

    public function scopeStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    public function scopeJournalType(Builder $query, string $type): Builder
    {
        return $query->where('journal_type', $type);
    }

    public function scopeJournalDateBetween(Builder $query, string $startDate, string $endDate): Builder
    {
        return $query->whereBetween('journal_date', [$startDate, $endDate]);
    }
}
