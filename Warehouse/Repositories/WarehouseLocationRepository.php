<?php

namespace Warehouse\Repositories;

use Warehouse\Models\WarehouseLocation;

final class WarehouseLocationRepository extends \MasterData\Repositories\BaseRepository
{
    public function __construct(WarehouseLocation $model)
    {
        parent::__construct($model);
    }
}
