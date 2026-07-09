<?php

namespace MasterData\Http\Controllers;

use MasterData\Http\Requests\CustomerRequest;
use MasterData\Http\Resources\CustomerResource;
use MasterData\Services\CustomerService;

class CustomerController extends BaseController
{
    public function __construct(CustomerService $service)
    {
        parent::__construct($service, CustomerResource::class, CustomerRequest::class);
    }
}