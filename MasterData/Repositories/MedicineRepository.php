<?php

namespace MasterData\Repositories;

use MasterData\Models\Medicine;

final class MedicineRepository extends BaseRepository
{
    public function __construct(Medicine $model)
    {
        parent::__construct($model);
    }
}