<?php

namespace Warehouse\Services;

use Warehouse\Repositories\WarehouseLocationRepository;

final class WarehouseLocationService extends \MasterData\Services\BaseService
{
    public function __construct(WarehouseLocationRepository $repository)
    {
        parent::__construct($repository);
    }
}
