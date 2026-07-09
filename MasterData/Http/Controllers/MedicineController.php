<?php

namespace MasterData\Http\Controllers;

use MasterData\Http\Requests\MedicineRequest;
use MasterData\Http\Resources\MedicineResource;
use MasterData\Services\MedicineService;

class MedicineController extends BaseController
{
    public function __construct(MedicineService $service)
    {
        parent::__construct($service, MedicineResource::class, MedicineRequest::class);
    }
}