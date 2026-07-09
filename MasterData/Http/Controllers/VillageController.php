<?php

namespace MasterData\Http\Controllers;

use MasterData\Http\Requests\VillageRequest;
use MasterData\Http\Resources\VillageResource;
use MasterData\Services\VillageService;

class VillageController extends BaseController
{
    public function __construct(VillageService $service)
    {
        parent::__construct($service, VillageResource::class, VillageRequest::class);
    }
}