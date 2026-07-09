<?php

namespace MasterData\Services;

use MasterData\Repositories\CompanyRepository;

final class CompanyService extends BaseService
{
    public function __construct(CompanyRepository $repository)
    {
        parent::__construct($repository);
    }
}