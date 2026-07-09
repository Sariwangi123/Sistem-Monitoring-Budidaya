<?php

namespace MasterData\Services;

use MasterData\Repositories\ProvinceRepository;

final class ProvinceService extends BaseService
{
    public function __construct(ProvinceRepository $repository)
    {
        parent::__construct($repository);
    }
}