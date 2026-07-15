<?php

namespace Finance\Http\Requests;

use Illuminate\Validation\Rule;
use MasterData\Http\Requests\BaseRequest;

final class FinanceLedgerRequest extends BaseRequest
{
    public function rules(): array
    {
        $uuid = $this->route('ledger') ?? $this->route('id');

        return [
            'company_id' => ['required', 'integer', 'exists:companies,id'],
            'farm_id' => ['nullable', 'integer', 'exists:farms,id'],
            'culture_cycle_id' => ['nullable', 'integer', 'exists:culture_cycles,id'],
            'cost_center_id' => ['required', 'integer', 'exists:finance_cost_centers,id'],
            'expense_id' => ['nullable', 'integer', 'exists:finance_expenses,id'],
            'revenue_id' => ['nullable', 'integer', 'exists:finance_revenues,id'],
            'journal_id' => ['nullable', 'integer', 'exists:finance_journals,id'],
            'ledger_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('finance_ledgers', 'ledger_number')->ignore($uuid, 'uuid'),
            ],
            'document_number' => ['required', 'string', 'max:255'],
            'ledger_date' => ['required', 'date'],
            'ledger_type' => [
                'required',
                'string',
                Rule::in(['Expense', 'Revenue', 'Journal', 'Adjustment', 'Allocation', 'Other']),
            ],
            'account_code' => ['nullable', 'string', 'max:255'],
            'account_name' => ['nullable', 'string', 'max:255'],
            'debit_amount' => ['sometimes', 'numeric', 'min:0'],
            'credit_amount' => ['sometimes', 'numeric', 'min:0'],
            'balance_amount' => ['sometimes', 'numeric'],
            'currency' => ['sometimes', 'string', 'max:3'],
            'source_type' => ['nullable', 'string', 'max:255'],
            'source_uuid' => ['nullable', 'uuid'],
            'posted_at' => ['nullable', 'date'],
            'status' => [
                'required',
                'string',
                Rule::in(['Draft', 'Posted', 'Closed']),
            ],
            'description' => ['nullable', 'string'],
        ];
    }
}
