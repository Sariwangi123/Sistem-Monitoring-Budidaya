<?php

namespace MasterData\Repositories;

use MasterData\Models\Vitamin;

final class VitaminRepository extends BaseRepository
{
    public function __construct(Vitamin $model)
    {
        parent::__construct($model);
    }
}