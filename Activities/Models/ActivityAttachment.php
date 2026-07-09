<?php

namespace Activities\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityAttachment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'activity_attachments';

    protected $fillable = [
        'uuid',
        'activity_id',
        'file_name',
        'file_type',
        'file_size',
        'storage_path',
        'description',
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

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }
}