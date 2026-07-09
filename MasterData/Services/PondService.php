<?php

namespace MasterData\Services;

use MasterData\Repositories\PondRepository;

final class PondService extends BaseService
{
    public function __construct(PondRepository $repository)
    {
        parent::__construct($repository);
    }
}