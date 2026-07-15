<?php

namespace Finance\Http\Resources;

use Illuminate\Http\Request;
use MasterData\Http\Resources\BaseResource;

final class FinanceJournalEntryResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'journal_id' => $this->journal_id,
            'ledger_id' => $this->ledger_id,
            'cost_center_id' => $this->cost_center_id,
            'account_code' => $this->account_code,
            'account_name' => $this->account_name,
            'entry_type' => $this->entry_type,
            'debit_amount' => $this->debit_amount,
            'credit_amount' => $this->credit_amount,
            'line_order' => $this->line_order,
            'description' => $this->description,
            ...$this->getAuditFields($request),
        ];
    }
}
