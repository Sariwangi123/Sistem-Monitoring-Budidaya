<?php

namespace MasterData\Http\Controllers;

use MasterData\Http\Requests\FeedTypeRequest;
use MasterData\Http\Resources\FeedTypeResource;
use MasterData\Services\FeedTypeService;

class FeedTypeController extends BaseController
{
    public function __construct(FeedTypeService $service)
    {
        parent::__construct($service, FeedTypeResource::class, FeedTypeRequest::class);
    }
}