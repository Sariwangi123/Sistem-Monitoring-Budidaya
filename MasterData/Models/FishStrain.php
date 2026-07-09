<?php

namespace MasterData\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Shared\Support\Auditable;
use Shared\Support\HasUuidColumn;

class FishStrain extends Model
{
    use Auditable;
    use HasUuidColumn;
    use SoftDeletes;

    protected $table = 'fish_strains';

    protected $fillable = [
        'uuid',
        'fish_species_id',
        'fish_strain_code',
        'fish_strain_name',
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

    public function fishSpecies(): BelongsTo
    {
        return $this->belongsTo(FishSpecies::class);
    }
}