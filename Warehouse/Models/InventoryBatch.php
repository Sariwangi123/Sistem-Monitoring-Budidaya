<?php

namespace Warehouse\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Shared\Support\Auditable;
use Shared\Support\HasUuidColumn;
use Database\Factories\Warehouse\InventoryBatchFactory;

class InventoryBatch extends Model
{
    use HasFactory;
    use Auditable;
    use HasUuidColumn;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'inventory_item_id',
        'warehouse_location_id',
        'batch_number',
        'lot_number',
        'production_date',
        'expired_date',
        'received_date',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'production_date' => 'date',
        'expired_date' => 'date',
        'received_date' => 'date',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(InventoryItem::class, 'inventory_item_id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(WarehouseLocation::class, 'warehouse_location_id');
    }

    public function movements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class, 'batch_id');
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(InventoryStock::class, 'batch_id');
    }

    protected static function newFactory(): InventoryBatchFactory
    {
        return InventoryBatchFactory::new();
    }
}
