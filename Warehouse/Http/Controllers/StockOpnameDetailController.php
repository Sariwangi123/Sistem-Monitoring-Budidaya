<?php

namespace Warehouse\Http\Controllers;

use MasterData\Http\Controllers\BaseController;
use Warehouse\Http\Requests\StockOpnameDetailRequest;
use Warehouse\Http\Resources\StockOpnameDetailResource;
use Warehouse\Services\StockOpnameDetailService;

final class StockOpnameDetailController extends BaseController
{
    public function __construct(StockOpnameDetailService $service)
    {
        parent::__construct($service, StockOpnameDetailResource::class, StockOpnameDetailRequest::class);
    }
}
