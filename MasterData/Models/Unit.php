<?php

namespace MasterData\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Shared\Support\Auditable;
use Shared\Support\HasUuidColumn;

class Unit extends Model
{
    use Auditable;
    use HasUuidColumn;
    use SoftDeletes;

    protected $table = 'units';

    protected $fillable = [
        'uuid',
        'unit_code',
        'unit_name',
        'unit_symbol',
        'description',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
}