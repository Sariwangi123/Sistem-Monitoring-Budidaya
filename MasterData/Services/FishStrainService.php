<?php

namespace MasterData\Services;

use MasterData\Repositories\FishStrainRepository;

final class FishStrainService extends BaseService
{
    public function __construct(FishStrainRepository $repository)
    {
        parent::__construct($repository);
    }
}