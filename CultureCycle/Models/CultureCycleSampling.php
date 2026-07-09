<?php

namespace CultureCycle\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class CultureCycleSampling extends Model
{
    use SoftDeletes, HasUuids;

    protected $table = 'culture_cycle_samplings';

    protected $fillable = [
        'uuid',
        'culture_cycle_id',
        'sampling_date',
        'sample_count',
        'average_weight',
        'average_length',
        'biomass',
        'adg',
        'survival_rate',
        'notes',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'sampling_date' => 'date',
        'average_weight' => 'decimal:4',
        'average_length' => 'decimal:4',
        'biomass' => 'decimal:4',
        'adg' => 'decimal:4',
        'survival_rate' => 'decimal:4',
    ];

    public function cultureCycle()
    {
        return $this->belongsTo(CultureCycle::class);
    }
}