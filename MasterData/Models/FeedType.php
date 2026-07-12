<?php

namespace MasterData\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Shared\Support\Auditable;
use Shared\Support\HasModuleFactory;
use Shared\Support\HasUuidColumn;

class FeedType extends Model
{
    use Auditable;
    use HasModuleFactory;
    use HasUuidColumn;
    use SoftDeletes;

    protected $table = 'feed_types';

    protected $fillable = [
        'uuid',
        'feed_brand_id',
        'feed_category_id',
        'feed_type_code',
        'feed_type_name',
        'protein_content',
        'fat_content',
        'fiber_content',
        'moisture',
        'package_size',
        'unit_id',
        'description',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'protein_content' => 'decimal:2',
        'fat_content' => 'decimal:2',
        'fiber_content' => 'decimal:2',
        'moisture' => 'decimal:2',
        'package_size' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function feedBrand(): BelongsTo
    {
        return $this->belongsTo(FeedBrand::class);
    }

    public function feedCategory(): BelongsTo
    {
        return $this->belongsTo(FeedCategory::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}