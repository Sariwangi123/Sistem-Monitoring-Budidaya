<?php

namespace MasterData\Services;

use MasterData\Repositories\ProbioticRepository;

final class ProbioticService extends BaseService
{
    public function __construct(ProbioticRepository $repository)
    {
        parent::__construct($repository);
    }
}