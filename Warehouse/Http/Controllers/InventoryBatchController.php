<?php

namespace Warehouse\Http\Controllers;

use MasterData\Http\Controllers\BaseController;
use Warehouse\Http\Requests\InventoryBatchRequest;
use Warehouse\Http\Resources\InventoryBatchResource;
use Warehouse\Services\InventoryBatchService;

final class InventoryBatchController extends BaseController
{
    public function __construct(InventoryBatchService $service)
    {
        parent::__construct($service, InventoryBatchResource::class, InventoryBatchRequest::class);
    }
}
