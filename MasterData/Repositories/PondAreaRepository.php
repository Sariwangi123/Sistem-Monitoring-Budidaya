<?php

namespace MasterData\Repositories;

use MasterData\Models\PondArea;

final class PondAreaRepository extends BaseRepository
{
    public function __construct(PondArea $model)
    {
        parent::__construct($model);
    }
}