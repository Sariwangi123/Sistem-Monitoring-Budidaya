<?php

namespace Harvest\Models;

use Activities\Models\Activity;
use CultureCycle\Models\CultureCycle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use MasterData\Models\Company;
use MasterData\Models\Customer;
use MasterData\Models\Farm;
use MasterData\Models\Pond;
use MasterData\Models\PondArea;
use Modules\Users\Models\User;
use Shared\Support\Auditable;
use Shared\Support\HasModuleFactory;
use Shared\Support\HasUuidColumn;

class Harvest extends Model
{
    use Auditable;
    use HasModuleFactory;
    use HasUuidColumn;
    use SoftDeletes;

    protected $table = 'harvests';

    protected $fillable = [
        'uuid',
        'company_id',
        'farm_id',
        'pond_area_id',
        'pond_id',
        'culture_cycle_id',
        'customer_id',
        'responsible_user_id',
        'activity_id',
        'harvest_code',
        'harvest_name',
        'harvest_type',
        'planned_harvest_date',
        'harvest_date',
        'started_at',
        'completed_at',
        'estimated_population',
        'estimated_biomass',
        'total_harvest_population',
        'total_harvest_weight',
        'average_weight',
        'survival_rate',
        'feed_conversion_ratio',
        'average_daily_gain',
        'status',
        'notes',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'planned_harvest_date' => 'date',
        'harvest_date' => 'date',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'estimated_population' => 'integer',
        'estimated_biomass' => 'decimal:2',
        'total_harvest_population' => 'integer',
        'total_harvest_weight' => 'decimal:2',
        'average_weight' => 'decimal:4',
        'survival_rate' => 'decimal:4',
        'feed_conversion_ratio' => 'decimal:4',
        'average_daily_gain' => 'decimal:4',
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

    public function pondArea(): BelongsTo
    {
        return $this->belongsTo(PondArea::class);
    }

    public function pond(): BelongsTo
    {
        return $this->belongsTo(Pond::class);
    }

    public function cultureCycle(): BelongsTo
    {
        return $this->belongsTo(CultureCycle::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function responsibleUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_user_id');
    }

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    public function batches(): HasMany
    {
        return $this->hasMany(HarvestBatch::class);
    }

    public function qualityControls(): HasMany
    {
        return $this->hasMany(HarvestQualityControl::class);
    }

    public function grades(): HasMany
    {
        return $this->hasMany(HarvestGrade::class);
    }

    public function packings(): HasMany
    {
        return $this->hasMany(HarvestPacking::class);
    }

    public function deliveries(): HasMany
    {
        return $this->hasMany(HarvestDelivery::class);
    }

    public function scopeStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    public function scopeHarvestType(Builder $query, string $harvestType): Builder
    {
        return $query->where('harvest_type', $harvestType);
    }
}
