<?php

namespace Harvest\Http\Controllers;

use MasterData\Http\Controllers\BaseController;
use Harvest\Http\Requests\HarvestGradeRequest;
use Harvest\Http\Resources\HarvestGradeResource;
use Harvest\Services\HarvestGradeService;

class HarvestGradeController extends BaseController
{
    public function __construct(HarvestGradeService $service)
    {
        parent::__construct($service, HarvestGradeResource::class, HarvestGradeRequest::class);
    }
}