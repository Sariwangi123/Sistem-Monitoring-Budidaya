<?php

namespace Finance\Http\Requests;

use Illuminate\Validation\Rule;
use MasterData\Http\Requests\BaseRequest;

final class FinanceJournalEntryRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'journal_id' => ['required', 'integer', 'exists:finance_journals,id'],
            'ledger_id' => ['nullable', 'integer', 'exists:finance_ledgers,id'],
            'cost_center_id' => ['nullable', 'integer', 'exists:finance_cost_centers,id'],
            'account_code' => ['required', 'string', 'max:255'],
            'account_name' => ['required', 'string', 'max:255'],
            'entry_type' => ['required', 'string', Rule::in(['Debit', 'Credit'])],
            'debit_amount' => ['sometimes', 'numeric', 'min:0'],
            'credit_amount' => ['sometimes', 'numeric', 'min:0'],
            'line_order' => ['sometimes', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
        ];
    }
}
