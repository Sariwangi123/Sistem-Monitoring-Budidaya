<?php

namespace MasterData\Http\Controllers;

use MasterData\Http\Requests\PondAreaRequest;
use MasterData\Http\Resources\PondAreaResource;
use MasterData\Services\PondAreaService;

class PondAreaController extends BaseController
{
    public function __construct(PondAreaService $service)
    {
        parent::__construct($service, PondAreaResource::class, PondAreaRequest::class);
    }
}