<?php

namespace Harvest\Repositories;

use Harvest\Models\Harvest;
use Harvest\Repositories\Contracts\HarvestRepositoryInterface;
use MasterData\Repositories\BaseRepository;

final class HarvestRepository extends BaseRepository implements HarvestRepositoryInterface
{
    public function __construct(Harvest $model)
    {
        parent::__construct($model);
    }
}
