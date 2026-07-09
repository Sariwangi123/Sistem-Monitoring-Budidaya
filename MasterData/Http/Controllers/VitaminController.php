<?php

namespace MasterData\Http\Controllers;

use MasterData\Http\Requests\VitaminRequest;
use MasterData\Http\Resources\VitaminResource;
use MasterData\Services\VitaminService;

class VitaminController extends BaseController
{
    public function __construct(VitaminService $service)
    {
        parent::__construct($service, VitaminResource::class, VitaminRequest::class);
    }
}