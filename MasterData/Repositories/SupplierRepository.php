<?php

namespace MasterData\Repositories;

use MasterData\Models\Supplier;

final class SupplierRepository extends BaseRepository
{
    public function __construct(Supplier $model)
    {
        parent::__construct($model);
    }
}