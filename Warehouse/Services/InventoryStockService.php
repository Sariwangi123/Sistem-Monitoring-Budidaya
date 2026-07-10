<?php

namespace Warehouse\Services;

use Warehouse\Repositories\InventoryStockRepository;

final class InventoryStockService extends \MasterData\Services\BaseService
{
    public function __construct(InventoryStockRepository $repository)
    {
        parent::__construct($repository);
    }
}
