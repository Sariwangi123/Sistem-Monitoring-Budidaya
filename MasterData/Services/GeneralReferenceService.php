<?php

namespace MasterData\Services;

use MasterData\Repositories\GeneralReferenceRepository;

final class GeneralReferenceService extends BaseService
{
    public function __construct(GeneralReferenceRepository $repository)
    {
        parent::__construct($repository);
    }
}