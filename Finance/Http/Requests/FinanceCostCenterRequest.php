<?php

namespace Finance\Http\Requests;

use Illuminate\Validation\Rule;
use MasterData\Http\Requests\BaseRequest;

final class FinanceCostCenterRequest extends BaseRequest
{
    public function rules(): array
    {
        $uuid = $this->route('cost_center') ?? $this->route('id');

        return [
            'company_id' => ['required', 'integer', 'exists:companies,id'],
            'farm_id' => ['nullable', 'integer', 'exists:farms,id'],
            'pond_id' => ['nullable', 'integer', 'exists:ponds,id'],
            'culture_cycle_id' => ['nullable', 'integer', 'exists:culture_cycles,id'],
            'cost_center_code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('finance_cost_centers', 'cost_center_code')->ignore($uuid, 'uuid'),
            ],
            'cost_center_name' => ['required', 'string', 'max:255'],
            'cost_center_type' => ['required', 'string', Rule::in(['Farm', 'Pond', 'Culture Cycle'])],
            'effective_from' => ['required', 'date'],
            'effective_to' => ['nullable', 'date', 'after_or_equal:effective_from'],
            'status' => ['required', 'string', Rule::in(['Active', 'Inactive'])],
            'description' => ['nullable', 'string'],
        ];
    }
}
