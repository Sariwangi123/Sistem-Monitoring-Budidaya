<?php

namespace Warehouse\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Shared\Support\Auditable;
use Shared\Support\HasUuidColumn;
use Database\Factories\Warehouse\InventoryStockFactory;

class InventoryStock extends Model
{
    use HasFactory;
    use Auditable;
    use HasUuidColumn;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'inventory_item_id',
        'warehouse_location_id',
        'batch_id',
        'current_quantity',
        'reserved_quantity',
        'available_quantity',
        'last_movement_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'current_quantity' => 'decimal:2',
        'reserved_quantity' => 'decimal:2',
        'available_quantity' => 'decimal:2',
        'last_movement_at' => 'datetime',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(InventoryItem::class, 'inventory_item_id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(WarehouseLocation::class, 'warehouse_location_id');
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(InventoryBatch::class, 'batch_id');
    }

    protected static function newFactory(): InventoryStockFactory
    {
        return InventoryStockFactory::new();
    }
}
