<?php

namespace MasterData\Services;

use MasterData\Repositories\PondAreaRepository;

final class PondAreaService extends BaseService
{
    public function __construct(PondAreaRepository $repository)
    {
        parent::__construct($repository);
    }
}