<?php

namespace MasterData\Http\Controllers;

use MasterData\Http\Requests\FeedBrandRequest;
use MasterData\Http\Resources\FeedBrandResource;
use MasterData\Services\FeedBrandService;

class FeedBrandController extends BaseController
{
    public function __construct(FeedBrandService $service)
    {
        parent::__construct($service, FeedBrandResource::class, FeedBrandRequest::class);
    }
}