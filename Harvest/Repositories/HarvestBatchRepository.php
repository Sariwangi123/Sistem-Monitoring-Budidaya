<?php

namespace Harvest\Repositories;

use Harvest\Models\HarvestBatch;
use Harvest\Repositories\Contracts\HarvestBatchRepositoryInterface;
use MasterData\Repositories\BaseRepository;

final class HarvestBatchRepository extends BaseRepository implements HarvestBatchRepositoryInterface
{
    public function __construct(HarvestBatch $model)
    {
        parent::__construct($model);
    }
}
