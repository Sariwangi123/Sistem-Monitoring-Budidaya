<?php

namespace MasterData\Repositories;

use MasterData\Models\Employee;

final class EmployeeRepository extends BaseRepository
{
    public function __construct(Employee $model)
    {
        parent::__construct($model);
    }
}