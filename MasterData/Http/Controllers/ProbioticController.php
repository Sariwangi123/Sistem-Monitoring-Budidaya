<?php

namespace MasterData\Http\Controllers;

use MasterData\Http\Requests\ProbioticRequest;
use MasterData\Http\Resources\ProbioticResource;
use MasterData\Services\ProbioticService;

class ProbioticController extends BaseController
{
    public function __construct(ProbioticService $service)
    {
        parent::__construct($service, ProbioticResource::class, ProbioticRequest::class);
    }
}