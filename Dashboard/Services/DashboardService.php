<?php

namespace Dashboard\Services;

use Dashboard\Engines\DashboardEngine;
use Dashboard\Repositories\Contracts\DashboardRepositoryInterface;
use Dashboard\Workspaces\DashboardWorkspace;

final class DashboardService
{
    public function __construct(
        private DashboardRepositoryInterface $repository,
        private DashboardEngine $dashboardEngine
    )
    {
    }

    public function getOperationalSnapshot(int $perPage = 15): array
    {
        return $this->repository->getOperationalSnapshot($perPage);
    }

    public function getWorkspace(
        array $roleSlugs,
        ?string $requestedWorkspace = null,
        int $perPage = 15
    ): DashboardWorkspace {
        return $this->dashboardEngine->buildWorkspace(
            $this,
            $roleSlugs,
            $requestedWorkspace,
            $perPage
        );
    }
}
