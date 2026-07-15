<?php

namespace Dashboard\Repositories\Contracts;

interface DashboardRepositoryInterface
{
    public function getOperationalSnapshot(int $perPage): array;
}
