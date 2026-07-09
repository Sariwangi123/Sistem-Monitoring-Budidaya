<?php

namespace CultureCycle\Models;

use App\Models\Traits\HasCompanyTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class CultureCycle extends Model
{
    use SoftDeletes, HasUuids, HasCompanyTrait;

    protected $table = 'culture_cycles';

    protected $fillable = [
        'uuid',
        'company_id',
        'farm_id',
        'pond_area_id',
        'pond_id',
        'fish_species_id',
        'fish_strain_id',
        'supplier_id',
        'employee_id',
        'cycle_code',
        'cycle_name',
        'stocking_date',
        'estimated_harvest_date',
        'actual_harvest_date',
        'initial_seed_quantity',
        'current_population',
        'initial_average_weight',
        'current_average_weight',
        'current_biomass',
        'status',
        'notes',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'stocking_date' => 'date',
        'estimated_harvest_date' => 'date',
        'actual_harvest_date' => 'date',
        'initial_average_weight' => 'decimal:4',
        'current_average_weight' => 'decimal:4',
        'current_biomass' => 'decimal:4',
    ];

    // Relations
    public function company()
    {
        return $this->belongsTo(\MasterData\Models\Company::class);
    }

    public function farm()
    {
        return $this->belongsTo(\MasterData\Models\Farm::class);
    }

    public function pondArea()
    {
        return $this->belongsTo(\MasterData\Models\PondArea::class);
    }

    public function pond()
    {
        return $this->belongsTo(\MasterData\Models\Pond::class);
    }

    public function fishSpecies()
    {
        return $this->belongsTo(\MasterData\Models\FishSpecies::class);
    }

    public function fishStrain()
    {
        return $this->belongsTo(\MasterData\Models\FishStrain::class);
    }

    public function supplier()
    {
        return $this->belongsTo(\MasterData\Models\Supplier::class);
    }

    public function employee()
    {
        return $this->belongsTo(\MasterData\Models\Employee::class);
    }

    public function samplings()
    {
        return $this->hasMany(\CultureCycle\Models\CultureCycleSampling::class, 'culture_cycle_id');
    }

    public function mortalities()
    {
        return $this->hasMany(\CultureCycle\Models\CultureCycleMortality::class, 'culture_cycle_id');
    }

    public function waterQualities()
    {
        return $this->hasMany(\CultureCycle\Models\CultureCycleWaterQuality::class, 'culture_cycle_id');
    }

    public function feedSummaries()
    {
        return $this->hasMany(\CultureCycle\Models\CultureCycleFeedSummary::class, 'culture_cycle_id');
    }
}