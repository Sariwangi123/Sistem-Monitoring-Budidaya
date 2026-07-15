<?php

namespace Finance\Http\Requests;

use Illuminate\Validation\Rule;
use MasterData\Http\Requests\BaseRequest;

final class FinanceFinancialSummaryRequest extends BaseRequest
{
    public function rules(): array
    {
        $uuid = $this->route('financial_summary') ?? $this->route('id');

        return [
            'company_id' => ['required', 'integer', 'exists:companies,id'],
            'farm_id' => ['nullable', 'integer', 'exists:farms,id'],
            'culture_cycle_id' => ['nullable', 'integer', 'exists:culture_cycles,id'],
            'cost_center_id' => ['nullable', 'integer', 'exists:finance_cost_centers,id'],
            'summary_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('finance_financial_summaries', 'summary_number')->ignore($uuid, 'uuid'),
            ],
            'summary_type' => [
                'required',
                'string',
                Rule::in(['Cycle', 'Monthly', 'Annual', 'Other']),
            ],
            'period_start' => ['required', 'date'],
            'period_end' => ['required', 'date', 'after_or_equal:period_start'],
            'status' => [
                'required',
                'string',
                Rule::in(['Draft', 'Completed', 'Closed', 'Locked']),
            ],
            'notes' => ['nullable', 'string'],
        ];
    }
}
