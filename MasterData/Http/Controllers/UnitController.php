<?php

namespace MasterData\Http\Controllers;

use MasterData\Http\Requests\UnitRequest;
use MasterData\Http\Resources\UnitResource;
use MasterData\Services\UnitService;

class UnitController extends BaseController
{
    public function __construct(UnitService $service)
    {
        parent::__construct($service, UnitResource::class, UnitRequest::class);
    }
}