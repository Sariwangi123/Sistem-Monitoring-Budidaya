<?php

namespace MasterData\Repositories;

use MasterData\Models\Farm;

final class FarmRepository extends BaseRepository
{
    public function __construct(Farm $model)
    {
        parent::__construct($model);
    }
}