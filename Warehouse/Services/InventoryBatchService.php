<?php

namespace Warehouse\Services;

use Warehouse\Repositories\InventoryBatchRepository;

final class InventoryBatchService extends \MasterData\Services\BaseService
{
    public function __construct(InventoryBatchRepository $repository)
    {
        parent::__construct($repository);
    }
}
