<?php

namespace MasterData\Http\Controllers;

use MasterData\Http\Requests\EmployeeRequest;
use MasterData\Http\Resources\EmployeeResource;
use MasterData\Services\EmployeeService;

class EmployeeController extends BaseController
{
    public function __construct(EmployeeService $service)
    {
        parent::__construct($service, EmployeeResource::class, EmployeeRequest::class);
    }
}