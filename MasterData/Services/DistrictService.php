<?php

namespace MasterData\Services;

use MasterData\Repositories\DistrictRepository;

final class DistrictService extends BaseService
{
    public function __construct(DistrictRepository $repository)
    {
        parent::__construct($repository);
    }
}