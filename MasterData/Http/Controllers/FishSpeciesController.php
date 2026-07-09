<?php

namespace MasterData\Http\Controllers;

use MasterData\Http\Requests\FishSpeciesRequest;
use MasterData\Http\Resources\FishSpeciesResource;
use MasterData\Services\FishSpeciesService;

class FishSpeciesController extends BaseController
{
    public function __construct(FishSpeciesService $service)
    {
        parent::__construct($service, FishSpeciesResource::class, FishSpeciesRequest::class);
    }
}