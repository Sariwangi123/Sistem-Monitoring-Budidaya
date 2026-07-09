<?php

namespace MasterData\Services;

use MasterData\Repositories\FeedTypeRepository;

final class FeedTypeService extends BaseService
{
    public function __construct(FeedTypeRepository $repository)
    {
        parent::__construct($repository);
    }
}