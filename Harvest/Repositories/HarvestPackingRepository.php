<?php

namespace Harvest\Repositories;

use Harvest\Models\HarvestPacking;
use Harvest\Repositories\Contracts\HarvestPackingRepositoryInterface;
use MasterData\Repositories\BaseRepository;

final class HarvestPackingRepository extends BaseRepository implements HarvestPackingRepositoryInterface
{
    public function __construct(HarvestPacking $model)
    {
        parent::__construct($model);
    }
}
