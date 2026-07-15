<?php

namespace Harvest\Http\Controllers;

use MasterData\Http\Controllers\BaseController;
use Harvest\Http\Requests\HarvestBatchRequest;
use Harvest\Http\Resources\HarvestBatchResource;
use Harvest\Services\HarvestBatchService;

class HarvestBatchController extends BaseController
{
    public function __construct(HarvestBatchService $service)
    {
        parent::__construct($service, HarvestBatchResource::class, HarvestBatchRequest::class);
    }
}