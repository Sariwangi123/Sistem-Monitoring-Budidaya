<?php

namespace MasterData\Repositories;

use MasterData\Models\Company;

final class CompanyRepository extends BaseRepository
{
    public function __construct(Company $model)
    {
        parent::__construct($model);
    }
}