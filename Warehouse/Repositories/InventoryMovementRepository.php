<?php

namespace Warehouse\Repositories;

use Warehouse\Models\InventoryMovement;

final class InventoryMovementRepository extends \MasterData\Repositories\BaseRepository
{
    public function __construct(InventoryMovement $model)
    {
        parent::__construct($model);
    }
}
