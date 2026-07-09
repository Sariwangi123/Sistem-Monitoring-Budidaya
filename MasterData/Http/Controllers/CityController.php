<?php

namespace MasterData\Http\Controllers;

use MasterData\Http\Requests\CityRequest;
use MasterData\Http\Resources\CityResource;
use MasterData\Services\CityService;

class CityController extends BaseController
{
    public function __construct(CityService $service)
    {
        parent::__construct($service, CityResource::class, CityRequest::class);
    }
}