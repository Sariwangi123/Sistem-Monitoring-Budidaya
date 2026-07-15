<?php

namespace Finance\Http\Requests;

use Illuminate\Validation\Rule;
use MasterData\Http\Requests\BaseRequest;

final class FinanceJournalRequest extends BaseRequest
{
    public function rules(): array
    {
        $uuid = $this->route('journal') ?? $this->route('id');

        return [
            'company_id' => ['required', 'integer', 'exists:companies,id'],
            'farm_id' => ['nullable', 'integer', 'exists:farms,id'],
            'user_id' => ['nullable', 'integer', 'exists:users,id'],
            'journal_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('finance_journals', 'journal_number')->ignore($uuid, 'uuid'),
            ],
            'document_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('finance_journals', 'document_number')->ignore($uuid, 'uuid'),
            ],
            'journal_date' => ['required', 'date'],
            'journal_type' => [
                'required',
                'string',
                Rule::in(['General', 'Expense', 'Revenue', 'Adjustment', 'Closing', 'Operational', 'Other']),
            ],
            'total_debit' => ['sometimes', 'numeric', 'min:0'],
            'total_credit' => ['sometimes', 'numeric', 'min:0'],
            'source_type' => ['nullable', 'string', 'max:255'],
            'source_uuid' => ['nullable', 'uuid'],
            'status' => [
                'required',
                'string',
                Rule::in(['Draft', 'Posted', 'Closed']),
            ],
            'description' => ['nullable', 'string'],
        ];
    }
}
