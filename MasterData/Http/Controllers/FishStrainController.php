<?php

namespace MasterData\Http\Controllers;

use MasterData\Http\Requests\FishStrainRequest;
use MasterData\Http\Resources\FishStrainResource;
use MasterData\Services\FishStrainService;

class FishStrainController extends BaseController
{
    public function __construct(FishStrainService $service)
    {
        parent::__construct($service, FishStrainResource::class, FishStrainRequest::class);
    }
}