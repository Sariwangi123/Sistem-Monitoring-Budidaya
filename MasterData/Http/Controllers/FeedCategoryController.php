<?php

namespace MasterData\Http\Controllers;

use MasterData\Http\Requests\FeedCategoryRequest;
use MasterData\Http\Resources\FeedCategoryResource;
use MasterData\Services\FeedCategoryService;

class FeedCategoryController extends BaseController
{
    public function __construct(FeedCategoryService $service)
    {
        parent::__construct($service, FeedCategoryResource::class, FeedCategoryRequest::class);
    }
}