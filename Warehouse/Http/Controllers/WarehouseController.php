<?php

namespace Warehouse\Http\Controllers;

use MasterData\Http\Controllers\BaseController;
use Warehouse\Http\Requests\WarehouseRequest;
use Warehouse\Http\Resources\WarehouseResource;
use Warehouse\Services\WarehouseService;

final class WarehouseController extends BaseController
{
    public function __construct(WarehouseService $service)
    {
        parent::__construct($service, WarehouseResource::class, WarehouseRequest::class);
    }
}
