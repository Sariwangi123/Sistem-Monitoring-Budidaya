<?php

namespace CultureCycle\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class CultureCycleFeedSummary extends Model
{
    use SoftDeletes, HasUuids;

    protected $table = 'culture_cycle_feed_summaries';

    protected $fillable = [
        'uuid',
        'culture_cycle_id',
        'feed_brand_id',
        'feed_type_id',
        'feed_date',
        'feed_quantity',
        'feeding_frequency',
        'feeding_duration',
        'fcr',
        'notes',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'feed_date' => 'date',
        'feed_quantity' => 'decimal:4',
        'fcr' => 'decimal:4',
    ];

    public function cultureCycle()
    {
        return $this->belongsTo(CultureCycle::class);
    }
}