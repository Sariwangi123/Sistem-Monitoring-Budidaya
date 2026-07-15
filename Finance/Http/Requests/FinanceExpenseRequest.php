<?php

namespace Finance\Http\Requests;

use Illuminate\Validation\Rule;
use MasterData\Http\Requests\BaseRequest;

final class FinanceExpenseRequest extends BaseRequest
{
    public function rules(): array
    {
        $uuid = $this->route('expense') ?? $this->route('id');

        return [
            'company_id' => ['required', 'integer', 'exists:companies,id'],
            'farm_id' => ['nullable', 'integer', 'exists:farms,id'],
            'culture_cycle_id' => ['nullable', 'integer', 'exists:culture_cycles,id'],
            'cost_center_id' => ['required', 'integer', 'exists:finance_cost_centers,id'],
            'expense_category_id' => ['nullable', 'integer', 'exists:general_references,id'],
            'supplier_id' => ['nullable', 'integer', 'exists:suppliers,id'],
            'activity_id' => ['nullable', 'integer', 'exists:activities,id'],
            'inventory_movement_id' => ['nullable', 'integer', 'exists:inventory_movements,id'],
            'user_id' => ['nullable', 'integer', 'exists:users,id'],
            'expense_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('finance_expenses', 'expense_number')->ignore($uuid, 'uuid'),
            ],
            'document_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('finance_expenses', 'document_number')->ignore($uuid, 'uuid'),
            ],
            'expense_date' => ['required', 'date'],
            'expense_type' => [
                'required',
                'string',
                Rule::in(['Feed', 'Medicine', 'Labor', 'Electricity', 'Maintenance', 'Operational', 'Vitamin', 'Chemical', 'Equipment', 'Other']),
            ],
            'payment_method' => ['nullable', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'tax_amount' => ['sometimes', 'numeric', 'min:0'],
            'total_amount' => ['sometimes', 'numeric', 'min:0'],
            'currency' => ['sometimes', 'string', 'max:3'],
            'source_type' => ['nullable', 'string', 'max:255'],
            'source_uuid' => ['nullable', 'uuid'],
            'status' => [
                'required',
                'string',
                Rule::in(['Draft', 'Validated', 'Posted', 'Completed', 'Closed', 'Locked']),
            ],
            'notes' => ['nullable', 'string'],
        ];
    }
}
