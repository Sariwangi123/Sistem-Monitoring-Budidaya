<?php

namespace Activities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Shared\Support\HasModuleFactory;

class ActivityType extends Model
{
    use HasModuleFactory, SoftDeletes;

    protected $table = 'activity_types';

    protected $fillable = [
        'uuid',
        'event_code',
        'activity_name',
        'activity_category_id',
        'icon',
        'color',
        'is_manual',
        'is_system',
        'status',
        'description',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected function casts(): array
    {
        return [
            'is_manual' => 'boolean',
            'is_system' => 'boolean',
        ];
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = (string) \Illuminate\Support\Str::uuid();
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ActivityCategory::class, 'activity_category_id');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class, 'activity_type_id');
    }
}