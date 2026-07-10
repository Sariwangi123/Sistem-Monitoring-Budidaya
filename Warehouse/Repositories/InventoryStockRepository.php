<?php

namespace Warehouse\Repositories;

use Warehouse\Models\InventoryStock;

final class InventoryStockRepository extends \MasterData\Repositories\BaseRepository
{
    public function __construct(InventoryStock $model)
    {
        parent::__construct($model);
    }
}
