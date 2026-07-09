<?php

namespace CultureCycle\Repositories;

use CultureCycle\Models\CultureCycle;

final class CultureCycleRepository extends \MasterData\Repositories\BaseRepository
{
    public function __construct(CultureCycle $model)
    {
        parent::__construct($model);
    }
}