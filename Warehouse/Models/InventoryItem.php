<?php

namespace Warehouse\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use MasterData\Models\GeneralReference;
use MasterData\Models\Supplier;
use MasterData\Models\Unit;
use Shared\Support\Auditable;
use Shared\Support\HasUuidColumn;
use Database\Factories\Warehouse\InventoryItemFactory;

class InventoryItem extends Model
{
    use HasFactory;
    use Auditable;
    use HasUuidColumn;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'item_category_id',
        'unit_id',
        'supplier_id',
        'item_code',
        'item_name',
        'brand',
        'specification',
        'minimum_stock',
        'maximum_stock',
        'reorder_level',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'minimum_stock' => 'decimal:2',
        'maximum_stock' => 'decimal:2',
        'reorder_level' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(GeneralReference::class, 'item_category_id');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function batches(): HasMany
    {
        return $this->hasMany(InventoryBatch::class);
    }

    public function movements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class);
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(InventoryStock::class);
    }

    protected static function newFactory(): InventoryItemFactory
    {
        return InventoryItemFactory::new();
    }
}
