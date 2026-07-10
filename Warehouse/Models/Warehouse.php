<?php

namespace Warehouse\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use MasterData\Models\Farm;
use Shared\Support\Auditable;
use Shared\Support\HasUuidColumn;
use Database\Factories\Warehouse\WarehouseFactory;

class Warehouse extends Model
{
    use HasFactory;
    use Auditable;
    use HasUuidColumn;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'farm_id',
        'warehouse_code',
        'warehouse_name',
        'description',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class);
    }

    public function locations(): HasMany
    {
        return $this->hasMany(WarehouseLocation::class);
    }

    public function movements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class);
    }

    public function stockOpnames(): HasMany
    {
        return $this->hasMany(StockOpname::class);
    }

    protected static function newFactory(): WarehouseFactory
    {
        return WarehouseFactory::new();
    }
}
