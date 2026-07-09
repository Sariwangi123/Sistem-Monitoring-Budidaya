<?php

namespace MasterData\Repositories;

use MasterData\Models\FeedCategory;

final class FeedCategoryRepository extends BaseRepository
{
    public function __construct(FeedCategory $model)
    {
        parent::__construct($model);
    }
}