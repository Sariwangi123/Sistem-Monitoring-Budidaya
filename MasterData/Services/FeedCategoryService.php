<?php

namespace MasterData\Services;

use MasterData\Repositories\FeedCategoryRepository;

final class FeedCategoryService extends BaseService
{
    public function __construct(FeedCategoryRepository $repository)
    {
        parent::__construct($repository);
    }
}