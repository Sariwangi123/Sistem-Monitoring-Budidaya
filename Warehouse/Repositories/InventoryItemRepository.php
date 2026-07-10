<?php

namespace Warehouse\Repositories;

use Warehouse\Models\InventoryItem;

final class InventoryItemRepository extends \MasterData\Repositories\BaseRepository
{
    public function __construct(InventoryItem $model)
    {
        parent::__construct($model);
    }
}
