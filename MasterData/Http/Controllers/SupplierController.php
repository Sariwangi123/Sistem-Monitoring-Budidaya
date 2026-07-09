<?php

namespace MasterData\Http\Controllers;

use MasterData\Http\Requests\SupplierRequest;
use MasterData\Http\Resources\SupplierResource;
use MasterData\Services\SupplierService;

class SupplierController extends BaseController
{
    public function __construct(SupplierService $service)
    {
        parent::__construct($service, SupplierResource::class, SupplierRequest::class);
    }
}