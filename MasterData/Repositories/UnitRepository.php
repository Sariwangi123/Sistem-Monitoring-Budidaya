<?php

namespace MasterData\Repositories;

use MasterData\Models\Unit;

final class UnitRepository extends BaseRepository
{
    public function __construct(Unit $model)
    {
        parent::__construct($model);
    }
}