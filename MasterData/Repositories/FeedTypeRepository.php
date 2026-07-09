<?php

namespace MasterData\Repositories;

use MasterData\Models\FeedType;

final class FeedTypeRepository extends BaseRepository
{
    public function __construct(FeedType $model)
    {
        parent::__construct($model);
    }
}