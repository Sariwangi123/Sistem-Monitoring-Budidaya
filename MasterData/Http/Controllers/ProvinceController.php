<?php

namespace MasterData\Http\Controllers;

use MasterData\Http\Requests\ProvinceRequest;
use MasterData\Http\Resources\ProvinceResource;
use MasterData\Services\ProvinceService;

class ProvinceController extends BaseController
{
    public function __construct(ProvinceService $service)
    {
        parent::__construct($service, ProvinceResource::class, ProvinceRequest::class);
    }
}