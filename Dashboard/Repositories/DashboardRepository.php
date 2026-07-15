<?php

namespace Dashboard\Repositories;

use Activities\Services\ActivityService;
use CultureCycle\Services\CultureCycleService;
use Dashboard\Repositories\Contracts\DashboardRepositoryInterface;
use Finance\Services\FinanceFinancialSummaryService;
use Harvest\Services\HarvestService;
use MasterData\Services\FarmService;
use Warehouse\Services\InventoryStockService;

final class DashboardRepository implements DashboardRepositoryInterface
{
    public function __construct(
        private FarmService $farmService,
        private CultureCycleService $cultureCycleService,
        private ActivityService $activityService,
        private InventoryStockService $inventoryStockService,
        private HarvestService $harvestService,
        private FinanceFinancialSummaryService $financialSummaryService
    ) {
    }

    public function getOperationalSnapshot(int $perPage): array
    {
        return [
            'farms' => $this->farmService->getPaginated($perPage),
            'culture_cycles' => $this->cultureCycleService->getPaginated($perPage),
            'activities' => $this->activityService->getPaginated($perPage),
            'inventory_stocks' => $this->inventoryStockService->getPaginated($perPage),
            'harvests' => $this->harvestService->getPaginated($perPage),
            'financial_summaries' => $this->financialSummaryService->getPaginated($perPage),
        ];
    }
}
