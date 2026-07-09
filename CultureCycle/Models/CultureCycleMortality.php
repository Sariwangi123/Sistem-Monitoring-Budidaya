<?php

namespace CultureCycle\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class CultureCycleMortality extends Model
{
    use SoftDeletes, HasUuids;

    protected $table = 'culture_cycle_mortalities';

    protected $fillable = [
        'uuid',
        'culture_cycle_id',
        'mortality_date',
        'dead_count',
        'mortality_reason',
        'notes',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'mortality_date' => 'date',
    ];

    public function cultureCycle()
    {
        return $this->belongsTo(CultureCycle::class);
    }
}