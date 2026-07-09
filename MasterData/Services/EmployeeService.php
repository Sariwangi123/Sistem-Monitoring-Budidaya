<?php

namespace MasterData\Services;

use MasterData\Repositories\EmployeeRepository;

final class EmployeeService extends BaseService
{
    public function __construct(EmployeeRepository $repository)
    {
        parent::__construct($repository);
    }
}