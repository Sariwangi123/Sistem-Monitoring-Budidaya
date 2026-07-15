<?php

namespace Finance\Http\Requests;

use Illuminate\Validation\Rule;
use MasterData\Http\Requests\BaseRequest;

final class FinanceCostAllocationRequest extends BaseRequest
{
    public function rules(): array
    {
        $uuid = $this->route('cost_allocation') ?? $this->route('id');

        return [
            'ledger_id' => ['required', 'integer', 'exists:finance_ledgers,id'],
            'source_cost_center_id' => ['nullable', 'integer', 'exists:finance_cost_centers,id'],
            'target_cost_center_id' => ['required', 'integer', 'exists:finance_cost_centers,id'],
            'culture_cycle_id' => ['nullable', 'integer', 'exists:culture_cycles,id'],
            'harvest_id' => ['nullable', 'integer', 'exists:harvests,id'],
            'allocation_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('finance_cost_allocations', 'allocation_number')->ignore($uuid, 'uuid'),
            ],
            'allocation_date' => ['required', 'date'],
            'allocation_method' => ['required', 'string', 'max:255'],
            'allocation_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
            'allocated_amount' => ['required', 'numeric', 'min:0'],
            'status' => [
                'required',
                'string',
                Rule::in(['Draft', 'Posted', 'Closed']),
            ],
            'notes' => ['nullable', 'string'],
        ];
    }
}
