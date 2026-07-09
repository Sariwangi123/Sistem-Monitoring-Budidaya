<?php

namespace MasterData\Repositories;

use MasterData\Models\FishSpecies;

final class FishSpeciesRepository extends BaseRepository
{
    public function __construct(FishSpecies $model)
    {
        parent::__construct($model);
    }
}