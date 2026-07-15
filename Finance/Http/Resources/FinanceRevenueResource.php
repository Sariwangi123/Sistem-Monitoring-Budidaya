<?php

namespace Finance\Http\Resources;

use Illuminate\Http\Request;
use MasterData\Http\Resources\BaseResource;

final class FinanceRevenueResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'company_id' => $this->company_id,
            'farm_id' => $this->farm_id,
            'culture_cycle_id' => $this->culture_cycle_id,
            'cost_center_id' => $this->cost_center_id,
            'revenue_category_id' => $this->revenue_category_id,
            'harvest_id' => $this->harvest_id,
            'harvest_delivery_id' => $this->harvest_delivery_id,
            'customer_id' => $this->customer_id,
            'user_id' => $this->user_id,
            'revenue_number' => $this->revenue_number,
            'document_number' => $this->document_number,
            'revenue_date' => $this->revenue_date?->format('Y-m-d'),
            'revenue_type' => $this->revenue_type,
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'amount' => $this->amount,
            'tax_amount' => $this->tax_amount,
            'discount_amount' => $this->discount_amount,
            'total_amount' => $this->total_amount,
            'currency' => $this->currency,
            'source_type' => $this->source_type,
            'source_uuid' => $this->source_uuid,
            'status' => $this->status,
            'notes' => $this->notes,
            ...$this->getAuditFields($request),
        ];
    }
}
