<?php

namespace Warehouse\Services;

use Warehouse\Repositories\InventoryItemRepository;

final class InventoryItemService extends \MasterData\Services\BaseService
{
    public function __construct(InventoryItemRepository $repository)
    {
        parent::__construct($repository);
    }
}
