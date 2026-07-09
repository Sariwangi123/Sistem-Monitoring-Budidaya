<?php

namespace MasterData\Repositories;

use MasterData\Models\Pond;

final class PondRepository extends BaseRepository
{
    public function __construct(Pond $model)
    {
        parent::__construct($model);
    }
}