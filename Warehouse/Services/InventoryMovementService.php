<?php

namespace Warehouse\Services;

use Warehouse\Repositories\InventoryMovementRepository;

final class InventoryMovementService extends \MasterData\Services\BaseService
{
    public function __construct(InventoryMovementRepository $repository)
    {
        parent::__construct($repository);
    }
}
