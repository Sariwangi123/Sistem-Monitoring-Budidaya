<?php

namespace MasterData\Http\Controllers;

use MasterData\Http\Requests\PondRequest;
use MasterData\Http\Resources\PondResource;
use MasterData\Services\PondService;

class PondController extends BaseController
{
    public function __construct(PondService $service)
    {
        parent::__construct($service, PondResource::class, PondRequest::class);
    }
}