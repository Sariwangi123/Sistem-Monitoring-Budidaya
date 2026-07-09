<?php

namespace CultureCycle\Http\Controllers;

use CultureCycle\Http\Requests\CultureCycleRequest;
use CultureCycle\Http\Resources\CultureCycleResource;
use CultureCycle\Services\CultureCycleService;
use MasterData\Http\Controllers\BaseController;

final class CultureCycleController extends BaseController
{
    public function __construct(CultureCycleService $service)
    {
        parent::__construct($service, CultureCycleResource::class, CultureCycleRequest::class);
    }
}