<?php

namespace Warehouse\Http\Controllers;

use MasterData\Http\Controllers\BaseController;
use Warehouse\Http\Requests\StockOpnameRequest;
use Warehouse\Http\Resources\StockOpnameResource;
use Warehouse\Services\StockOpnameService;

final class StockOpnameController extends BaseController
{
    public function __construct(StockOpnameService $service)
    {
        parent::__construct($service, StockOpnameResource::class, StockOpnameRequest::class);
    }
}
