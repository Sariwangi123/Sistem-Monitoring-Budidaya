<?php

namespace MasterData\Services;

use MasterData\Repositories\FeedBrandRepository;

final class FeedBrandService extends BaseService
{
    public function __construct(FeedBrandRepository $repository)
    {
        parent::__construct($repository);
    }
}