<?php

namespace MasterData\Http\Controllers;

use MasterData\Http\Requests\GeneralReferenceRequest;
use MasterData\Http\Resources\GeneralReferenceResource;
use MasterData\Services\GeneralReferenceService;

class GeneralReferenceController extends BaseController
{
    public function __construct(GeneralReferenceService $service)
    {
        parent::__construct($service, GeneralReferenceResource::class, GeneralReferenceRequest::class);
    }
}