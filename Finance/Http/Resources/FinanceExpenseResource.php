<?php

namespace Finance\Http\Resources;

use Illuminate\Http\Request;
use MasterData\Http\Resources\BaseResource;

final class FinanceExpenseResource extends BaseResource
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
            'expense_category_id' => $this->expense_category_id,
            'supplier_id' => $this->supplier_id,
            'activity_id' => $this->activity_id,
            'inventory_movement_id' => $this->inventory_movement_id,
            'user_id' => $this->user_id,
            'expense_number' => $this->expense_number,
            'document_number' => $this->document_number,
            'expense_date' => $this->expense_date?->format('Y-m-d'),
            'expense_type' => $this->expense_type,
            'payment_method' => $this->payment_method,
            'amount' => $this->amount,
            'tax_amount' => $this->tax_amount,
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
