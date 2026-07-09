<?php

namespace MasterData\Repositories;

use MasterData\Models\District;

final class DistrictRepository extends BaseRepository
{
    public function __construct(District $model)
    {
        parent::__construct($model);
    }
}