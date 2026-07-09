<?php

namespace MasterData\Services;

use MasterData\Repositories\SupplierRepository;

final class SupplierService extends BaseService
{
    public function __construct(SupplierRepository $repository)
    {
        parent::__construct($repository);
    }
}