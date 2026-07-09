<?php

namespace MasterData\Repositories;

use MasterData\Models\City;

final class CityRepository extends BaseRepository
{
    public function __construct(City $model)
    {
        parent::__construct($model);
    }
}