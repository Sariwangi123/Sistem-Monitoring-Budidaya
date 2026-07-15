<?php

namespace Finance\Http\Resources;

use Illuminate\Http\Request;
use MasterData\Http\Resources\BaseResource;

final class FinanceLedgerResource extends BaseResource
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
            'expense_id' => $this->expense_id,
            'revenue_id' => $this->revenue_id,
            'journal_id' => $this->journal_id,
            'ledger_number' => $this->ledger_number,
            'document_number' => $this->document_number,
            'ledger_date' => $this->ledger_date?->format('Y-m-d'),
            'ledger_type' => $this->ledger_type,
            'account_code' => $this->account_code,
            'account_name' => $this->account_name,
            'debit_amount' => $this->debit_amount,
            'credit_amount' => $this->credit_amount,
            'balance_amount' => $this->balance_amount,
            'currency' => $this->currency,
            'source_type' => $this->source_type,
            'source_uuid' => $this->source_uuid,
            'posted_at' => $this->posted_at?->format('Y-m-d H:i:s'),
            'status' => $this->status,
            'description' => $this->description,
            ...$this->getAuditFields($request),
        ];
    }
}
