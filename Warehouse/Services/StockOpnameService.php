<?php

namespace Warehouse\Services;

use Warehouse\Repositories\StockOpnameRepository;

final class StockOpnameService extends \MasterData\Services\BaseService
{
    public function __construct(StockOpnameRepository $repository)
    {
        parent::__construct($repository);
    }
}
