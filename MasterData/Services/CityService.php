<?php

namespace MasterData\Services;

use MasterData\Repositories\CityRepository;

final class CityService extends BaseService
{
    public function __construct(CityRepository $repository)
    {
        parent::__construct($repository);
    }
}