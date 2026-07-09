<?php

namespace MasterData\Services;

use MasterData\Repositories\UnitRepository;

final class UnitService extends BaseService
{
    public function __construct(UnitRepository $repository)
    {
        parent::__construct($repository);
    }
}