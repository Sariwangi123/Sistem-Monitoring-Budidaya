<?php

namespace CultureCycle\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Shared\Support\HasModuleFactory;

class CultureCycleWaterQuality extends Model
{
    use HasModuleFactory;
    use SoftDeletes;

    protected $table = 'culture_cycle_water_qualities';

    protected $fillable = [
        'uuid',
        'culture_cycle_id',
        'measurement_date',
        'temperature',
        'ph',
        'do',
        'ammonia',
        'nitrite',
        'salinity',
        'notes',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'measurement_date' => 'date',
        'temperature' => 'decimal:2',
        'ph' => 'decimal:2',
        'do' => 'decimal:2',
        'ammonia' => 'decimal:4',
        'nitrite' => 'decimal:4',
        'salinity' => 'decimal:2',
    ];

    public function cultureCycle()
    {
        return $this->belongsTo(CultureCycle::class);
    }
}