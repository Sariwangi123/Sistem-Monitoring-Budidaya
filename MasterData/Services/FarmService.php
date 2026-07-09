<?php

namespace MasterData\Services;

use MasterData\Repositories\FarmRepository;

final class FarmService extends BaseService
{
    public function __construct(FarmRepository $repository)
    {
        parent::__construct($repository);
    }
}