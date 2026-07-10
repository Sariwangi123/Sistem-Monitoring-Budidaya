<?php

namespace Warehouse\Repositories;

use Warehouse\Models\StockOpname;

final class StockOpnameRepository extends \MasterData\Repositories\BaseRepository
{
    public function __construct(StockOpname $model)
    {
        parent::__construct($model);
    }
}
