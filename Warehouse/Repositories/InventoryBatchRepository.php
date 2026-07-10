<?php

namespace Warehouse\Repositories;

use Warehouse\Models\InventoryBatch;

final class InventoryBatchRepository extends \MasterData\Repositories\BaseRepository
{
    public function __construct(InventoryBatch $model)
    {
        parent::__construct($model);
    }
}
