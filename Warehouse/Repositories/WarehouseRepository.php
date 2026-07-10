<?php

namespace Warehouse\Repositories;

use Warehouse\Models\Warehouse;

final class WarehouseRepository extends \MasterData\Repositories\BaseRepository
{
    public function __construct(Warehouse $model)
    {
        parent::__construct($model);
    }
}
