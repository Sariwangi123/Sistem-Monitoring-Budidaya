<?php

namespace MasterData\Http\Controllers;

use MasterData\Http\Requests\DistrictRequest;
use MasterData\Http\Resources\DistrictResource;
use MasterData\Services\DistrictService;

class DistrictController extends BaseController
{
    public function __construct(DistrictService $service)
    {
        parent::__construct($service, DistrictResource::class, DistrictRequest::class);
    }
}