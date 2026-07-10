<?php

namespace Warehouse\Http\Controllers;

use MasterData\Http\Controllers\BaseController;
use Warehouse\Http\Requests\InventoryMovementRequest;
use Warehouse\Http\Resources\InventoryMovementResource;
use Warehouse\Services\InventoryMovementService;

final class InventoryMovementController extends BaseController
{
    public function __construct(InventoryMovementService $service)
    {
        parent::__construct($service, InventoryMovementResource::class, InventoryMovementRequest::class);
    }
}
