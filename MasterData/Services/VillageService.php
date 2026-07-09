<?php

namespace MasterData\Services;

use MasterData\Repositories\VillageRepository;

final class VillageService extends BaseService
{
    public function __construct(VillageRepository $repository)
    {
        parent::__construct($repository);
    }
}