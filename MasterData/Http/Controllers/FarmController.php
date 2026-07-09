<?php

namespace MasterData\Http\Controllers;

use MasterData\Http\Requests\FarmRequest;
use MasterData\Http\Resources\FarmResource;
use MasterData\Services\FarmService;

class FarmController extends BaseController
{
    public function __construct(FarmService $service)
    {
        parent::__construct($service, FarmResource::class, FarmRequest::class);
    }
}