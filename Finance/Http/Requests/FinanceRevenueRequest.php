<?php

namespace Finance\Http\Requests;

use Illuminate\Validation\Rule;
use MasterData\Http\Requests\BaseRequest;

final class FinanceRevenueRequest extends BaseRequest
{
    public function rules(): array
    {
        $uuid = $this->route('revenue') ?? $this->route('id');

        return [
            'company_id' => ['required', 'integer', 'exists:companies,id'],
            'farm_id' => ['nullable', 'integer', 'exists:farms,id'],
            'culture_cycle_id' => ['nullable', 'integer', 'exists:culture_cycles,id'],
            'cost_center_id' => ['required', 'integer', 'exists:finance_cost_centers,id'],
            'revenue_category_id' => ['nullable', 'integer', 'exists:general_references,id'],
            'harvest_id' => ['nullable', 'integer', 'exists:harvests,id'],
            'harvest_delivery_id' => ['nullable', 'integer', 'exists:harvest_deliveries,id'],
            'customer_id' => ['nullable', 'integer', 'exists:customers,id'],
            'user_id' => ['nullable', 'integer', 'exists:users,id'],
            'revenue_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('finance_revenues', 'revenue_number')->ignore($uuid, 'uuid'),
            ],
            'document_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('finance_revenues', 'document_number')->ignore($uuid, 'uuid'),
            ],
            'revenue_date' => ['required', 'date'],
            'revenue_type' => [
                'required',
                'string',
                Rule::in(['Harvest', 'Service', 'Other']),
            ],
            'quantity' => ['required', 'numeric', 'min:0'],
            'unit_price' => ['required', 'numeric', 'min:0'],
            'amount' => ['required', 'numeric', 'min:0'],
            'tax_amount' => ['sometimes', 'numeric', 'min:0'],
            'discount_amount' => ['sometimes', 'numeric', 'min:0'],
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
