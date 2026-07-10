<?php

namespace Warehouse\Services;

use Warehouse\Repositories\WarehouseRepository;

final class WarehouseService extends \MasterData\Services\BaseService
{
    public function __construct(WarehouseRepository $repository)
    {
        parent::__construct($repository);
    }
}
