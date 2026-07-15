<?php

namespace Harvest\Http\Controllers;

use MasterData\Http\Controllers\BaseController;
use Harvest\Http\Requests\HarvestQualityControlRequest;
use Harvest\Http\Resources\HarvestQualityControlResource;
use Harvest\Services\HarvestQualityControlService;

class HarvestQualityControlController extends BaseController
{
    public function __construct(HarvestQualityControlService $service)
    {
        parent::__construct($service, HarvestQualityControlResource::class, HarvestQualityControlRequest::class);
    }
}