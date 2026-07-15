<?php

namespace Harvest\Repositories;

use Harvest\Models\HarvestGrade;
use Harvest\Repositories\Contracts\HarvestGradeRepositoryInterface;
use MasterData\Repositories\BaseRepository;

final class HarvestGradeRepository extends BaseRepository implements HarvestGradeRepositoryInterface
{
    public function __construct(HarvestGrade $model)
    {
        parent::__construct($model);
    }
}
