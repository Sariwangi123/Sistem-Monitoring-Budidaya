<?php

namespace Warehouse\Http\Controllers;

use MasterData\Http\Controllers\BaseController;
use Warehouse\Http\Requests\InventoryItemRequest;
use Warehouse\Http\Resources\InventoryItemResource;
use Warehouse\Services\InventoryItemService;

final class InventoryItemController extends BaseController
{
    public function __construct(InventoryItemService $service)
    {
        parent::__construct($service, InventoryItemResource::class, InventoryItemRequest::class);
    }
}
