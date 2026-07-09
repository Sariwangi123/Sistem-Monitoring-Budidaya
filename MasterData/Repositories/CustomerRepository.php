<?php

namespace MasterData\Repositories;

use MasterData\Models\Customer;

final class CustomerRepository extends BaseRepository
{
    public function __construct(Customer $model)
    {
        parent::__construct($model);
    }
}