<?php

namespace MasterData\Services;

use MasterData\Repositories\VitaminRepository;

final class VitaminService extends BaseService
{
    public function __construct(VitaminRepository $repository)
    {
        parent::__construct($repository);
    }
}