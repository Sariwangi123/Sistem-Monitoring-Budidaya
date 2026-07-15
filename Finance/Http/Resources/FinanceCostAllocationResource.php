<?php

namespace Finance\Http\Resources;

use Illuminate\Http\Request;
use MasterData\Http\Resources\BaseResource;

final class FinanceCostAllocationResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'ledger_id' => $this->ledger_id,
            'source_cost_center_id' => $this->source_cost_center_id,
            'target_cost_center_id' => $this->target_cost_center_id,
            'culture_cycle_id' => $this->culture_cycle_id,
            'harvest_id' => $this->harvest_id,
            'allocation_number' => $this->allocation_number,
            'allocation_date' => $this->allocation_date?->format('Y-m-d'),
            'allocation_method' => $this->allocation_method,
            'allocation_percentage' => $this->allocation_percentage,
            'allocated_amount' => $this->allocated_amount,
            'status' => $this->status,
            'notes' => $this->notes,
            ...$this->getAuditFields($request),
        ];
    }
}
