<?php

namespace Harvest\Repositories;

use Harvest\Models\HarvestQualityControl;
use Harvest\Repositories\Contracts\HarvestQualityControlRepositoryInterface;
use MasterData\Repositories\BaseRepository;

final class HarvestQualityControlRepository extends BaseRepository implements HarvestQualityControlRepositoryInterface
{
    public function __construct(HarvestQualityControl $model)
    {
        parent::__construct($model);
    }
}
