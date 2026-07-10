<?php

namespace Warehouse\Repositories;

use Warehouse\Models\StockOpnameDetail;

final class StockOpnameDetailRepository extends \MasterData\Repositories\BaseRepository
{
    public function __construct(StockOpnameDetail $model)
    {
        parent::__construct($model);
    }
}
