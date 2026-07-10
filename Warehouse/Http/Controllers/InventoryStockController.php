<?php

namespace Warehouse\Http\Controllers;

use MasterData\Http\Controllers\BaseController;
use Warehouse\Http\Requests\InventoryStockRequest;
use Warehouse\Http\Resources\InventoryStockResource;
use Warehouse\Services\InventoryStockService;

final class InventoryStockController extends BaseController
{
    public function __construct(InventoryStockService $service)
    {
        parent::__construct($service, InventoryStockResource::class, InventoryStockRequest::class);
    }
}
