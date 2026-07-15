<?php

namespace Dashboard\Http\Resources;

use Activities\Http\Resources\ActivityResource;
use CultureCycle\Http\Resources\CultureCycleResource;
use Finance\Http\Resources\FinanceFinancialSummaryResource;
use Harvest\Http\Resources\HarvestResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use MasterData\Http\Resources\FarmResource;
use Warehouse\Http\Resources\InventoryStockResource;

final class DashboardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'farms' => FarmResource::collection($this->resource['farms']->items()),
            'culture_cycles' => CultureCycleResource::collection($this->resource['culture_cycles']->items()),
            'activities' => ActivityResource::collection($this->resource['activities']->items()),
            'inventory_stocks' => InventoryStockResource::collection($this->resource['inventory_stocks']->items()),
            'harvests' => HarvestResource::collection($this->resource['harvests']->items()),
            'financial_summaries' => FinanceFinancialSummaryResource::collection($this->resource['financial_summaries']->items()),
            'pagination' => [
                'farms' => $this->pagination($this->resource['farms']),
                'culture_cycles' => $this->pagination($this->resource['culture_cycles']),
                'activities' => $this->pagination($this->resource['activities']),
                'inventory_stocks' => $this->pagination($this->resource['inventory_stocks']),
                'harvests' => $this->pagination($this->resource['harvests']),
                'financial_summaries' => $this->pagination($this->resource['financial_summaries']),
            ],
        ];
    }

    public function with(Request $request): array
    {
        return [
            'success' => true,
            'message' => 'Success',
        ];
    }

    private function pagination(object $paginator): array
    {
        return [
            'current_page' => $paginator->currentPage(),
            'per_page' => $paginator->perPage(),
            'total' => $paginator->total(),
            'last_page' => $paginator->lastPage(),
        ];
    }
}
