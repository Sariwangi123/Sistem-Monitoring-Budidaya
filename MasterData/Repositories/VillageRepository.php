<?php

namespace MasterData\Repositories;

use MasterData\Models\Village;

final class VillageRepository extends BaseRepository
{
    public function __construct(Village $model)
    {
        parent::__construct($model);
    }
}