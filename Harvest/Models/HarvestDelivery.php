<?php

namespace Harvest\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use MasterData\Models\Customer;
use Modules\Users\Models\User;
use Shared\Support\Auditable;
use Shared\Support\HasModuleFactory;
use Shared\Support\HasUuidColumn;

class HarvestDelivery extends Model
{
    use Auditable;
    use HasModuleFactory;
    use HasUuidColumn;
    use SoftDeletes;

    protected $table = 'harvest_deliveries';

    protected $fillable = [
        'uuid',
        'harvest_id',
        'harvest_packing_id',
        'customer_id',
        'driver_user_id',
        'delivery_code',
        'document_number',
        'delivery_date',
        'vehicle_number',
        'driver_name',
        'package_quantity',
        'delivered_weight',
        'delivery_status',
        'notes',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'delivery_date' => 'date',
        'package_quantity' => 'integer',
        'delivered_weight' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function harvest(): BelongsTo
    {
        return $this->belongsTo(Harvest::class);
    }

    public function packing(): BelongsTo
    {
        return $this->belongsTo(HarvestPacking::class, 'harvest_packing_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function driverUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'driver_user_id');
    }

    public function scopeStatus(Builder $query, string $status): Builder
    {
        return $query->where('delivery_status', $status);
    }
}
