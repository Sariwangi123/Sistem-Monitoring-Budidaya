<?php

namespace MasterData\Http\Controllers;

use MasterData\Http\Requests\CompanyRequest;
use MasterData\Http\Resources\CompanyResource;
use MasterData\Services\CompanyService;

class CompanyController extends BaseController
{
    public function __construct(CompanyService $service)
    {
        parent::__construct($service, CompanyResource::class, CompanyRequest::class);
    }
}