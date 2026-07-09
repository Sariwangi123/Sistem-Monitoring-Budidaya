<?php

namespace MasterData\Repositories;

use MasterData\Models\FishStrain;

final class FishStrainRepository extends BaseRepository
{
    public function __construct(FishStrain $model)
    {
        parent::__construct($model);
    }
}