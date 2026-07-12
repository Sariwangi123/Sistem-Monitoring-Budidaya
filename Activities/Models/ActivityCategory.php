<?php

namespace Activities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Shared\Support\HasModuleFactory;

class ActivityCategory extends Model
{
    use HasModuleFactory, SoftDeletes;

    protected $table = 'activity_categories';

    protected $fillable = [
        'uuid',
        'category_code',
        'category_name',
        'description',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = (string) \Illuminate\Support\Str::uuid();
        });
    }

    public function activityTypes(): HasMany
    {
        return $this->hasMany(ActivityType::class, 'activity_category_id');
    }
}