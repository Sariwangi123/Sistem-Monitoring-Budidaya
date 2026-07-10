<?php

namespace Warehouse\Http\Controllers;

use MasterData\Http\Controllers\BaseController;
use Warehouse\Http\Requests\WarehouseLocationRequest;
use Warehouse\Http\Resources\WarehouseLocationResource;
use Warehouse\Services\WarehouseLocationService;

final class WarehouseLocationController extends BaseController
{
    public function __construct(WarehouseLocationService $service)
    {
        parent::__construct($service, WarehouseLocationResource::class, WarehouseLocationRequest::class);
    }
}
