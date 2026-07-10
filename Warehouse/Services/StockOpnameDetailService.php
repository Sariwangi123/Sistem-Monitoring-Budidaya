<?php

namespace Warehouse\Services;

use Warehouse\Repositories\StockOpnameDetailRepository;

final class StockOpnameDetailService extends \MasterData\Services\BaseService
{
    public function __construct(StockOpnameDetailRepository $repository)
    {
        parent::__construct($repository);
    }
}
