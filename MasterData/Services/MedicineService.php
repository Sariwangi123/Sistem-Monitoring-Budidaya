<?php

namespace MasterData\Services;

use MasterData\Repositories\MedicineRepository;

final class MedicineService extends BaseService
{
    public function __construct(MedicineRepository $repository)
    {
        parent::__construct($repository);
    }
}