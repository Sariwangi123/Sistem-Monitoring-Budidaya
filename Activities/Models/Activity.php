<?php

namespace Activities\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'activities';

    protected $fillable = [
        'uuid',
        'company_id',
        'farm_id',
        'pond_area_id',
        'pond_id',
        'culture_cycle_id',
        'activity_type_id',
        'user_id',
        'activity_date',
        'activity_time',
        'event_code',
        'title',
        'description',
        'status',
        'reference_type',
        'reference_uuid',
        'metadata',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected function casts(): array
    {
        return [
            'activity_date' => 'date',
            'activity_time' => 'datetime:H:i:s',
            'metadata' => 'json',
        ];
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = (string) \Illuminate\Support\Str::uuid();
        });
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(\MasterData\Models\Company::class);
    }

    public function farm(): BelongsTo
    {
        return $this->belongsTo(\MasterData\Models\Farm::class);
    }

    public function pondArea(): BelongsTo
    {
        return $this->belongsTo(\MasterData\Models\PondArea::class);
    }

    public function pond(): BelongsTo
    {
        return $this->belongsTo(\MasterData\Models\Pond::class);
    }

    public function cultureCycle(): BelongsTo
    {
        return $this->belongsTo(\CultureCycle\Models\CultureCycle::class);
    }

    public function activityType(): BelongsTo
    {
        return $this->belongsTo(ActivityType::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(\Modules\Users\Models\User::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(ActivityAttachment::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(ActivityComment::class);
    }
}