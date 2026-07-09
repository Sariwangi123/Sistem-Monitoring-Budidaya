<?php

namespace MasterData\Services;

use MasterData\Repositories\CustomerRepository;

final class CustomerService extends BaseService
{
    public function __construct(CustomerRepository $repository)
    {
        parent::__construct($repository);
    }
}