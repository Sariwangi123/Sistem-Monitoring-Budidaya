<?php

namespace Finance\Http\Resources;

use Illuminate\Http\Request;
use MasterData\Http\Resources\BaseResource;

final class FinanceJournalResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'company_id' => $this->company_id,
            'farm_id' => $this->farm_id,
            'user_id' => $this->user_id,
            'journal_number' => $this->journal_number,
            'document_number' => $this->document_number,
            'journal_date' => $this->journal_date?->format('Y-m-d'),
            'journal_type' => $this->journal_type,
            'total_debit' => $this->total_debit,
            'total_credit' => $this->total_credit,
            'source_type' => $this->source_type,
            'source_uuid' => $this->source_uuid,
            'status' => $this->status,
            'description' => $this->description,
            ...$this->getAuditFields($request),
        ];
    }
}
