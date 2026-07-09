<?php

namespace MasterData\Services;

use MasterData\Repositories\FishSpeciesRepository;

final class FishSpeciesService extends BaseService
{
    public function __construct(FishSpeciesRepository $repository)
    {
        parent::__construct($repository);
    }
}