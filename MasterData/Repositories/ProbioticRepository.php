<?php

namespace MasterData\Repositories;

use MasterData\Models\Probiotic;

final class ProbioticRepository extends BaseRepository
{
    public function __construct(Probiotic $model)
    {
        parent::__construct($model);
    }
}