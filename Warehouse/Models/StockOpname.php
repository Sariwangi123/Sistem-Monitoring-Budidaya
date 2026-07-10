<?php

namespace Warehouse\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Users\Models\User;
use Shared\Support\Auditable;
use Shared\Support\HasUuidColumn;
use Database\Factories\Warehouse\StockOpnameFactory;

class StockOpname extends Model
{
    use HasFactory;
    use Auditable;
    use HasUuidColumn;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'warehouse_id',
        'user_id',
        'opname_number',
        'opname_date',
        'status',
        'notes',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'opname_date' => 'date',
    ];

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(StockOpnameDetail::class);
    }

    protected static function newFactory(): StockOpnameFactory
    {
        return StockOpnameFactory::new();
    }
}
