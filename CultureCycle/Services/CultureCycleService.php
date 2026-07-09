<?php

namespace CultureCycle\Services;

use CultureCycle\Repositories\CultureCycleRepository;

final class CultureCycleService extends \MasterData\Services\BaseService
{
    public function __construct(CultureCycleRepository $repository)
    {
        parent::__construct($repository);
    }
}