<?php

namespace Warehouse\Models;

use Activities\Models\Activity;
use CultureCycle\Models\CultureCycle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Users\Models\User;
use Shared\Support\Auditable;
use Shared\Support\HasUuidColumn;
use Database\Factories\Warehouse\InventoryMovementFactory;

class InventoryMovement extends Model
{
    use HasFactory;
    use Auditable;
    use HasUuidColumn;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'inventory_item_id',
        'warehouse_id',
        'warehouse_location_id',
        'batch_id',
        'culture_cycle_id',
        'activity_id',
        'user_id',
        'movement_number',
        'movement_type',
        'movement_date',
        'quantity',
        'unit_cost',
        'total_cost',
        'reference_type',
        'reference_uuid',
        'notes',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'movement_date' => 'date',
        'quantity' => 'decimal:2',
        'unit_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(InventoryItem::class, 'inventory_item_id');
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(WarehouseLocation::class, 'warehouse_location_id');
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(InventoryBatch::class, 'batch_id');
    }

    public function cultureCycle(): BelongsTo
    {
        return $this->belongsTo(CultureCycle::class);
    }

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function newFactory(): InventoryMovementFactory
    {
        return InventoryMovementFactory::new();
    }
}
