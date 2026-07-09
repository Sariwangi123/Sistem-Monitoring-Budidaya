<?php

namespace MasterData\Repositories;

use MasterData\Models\Province;

final class ProvinceRepository extends BaseRepository
{
    public function __construct(Province $model)
    {
        parent::__construct($model);
    }
}