<?php

namespace MasterData\Repositories;

use MasterData\Models\FeedBrand;

final class FeedBrandRepository extends BaseRepository
{
    public function __construct(FeedBrand $model)
    {
        parent::__construct($model);
    }
}