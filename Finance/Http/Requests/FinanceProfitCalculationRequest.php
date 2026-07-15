<?php

namespace Finance\Http\Requests;

use Illuminate\Validation\Rule;
use MasterData\Http\Requests\BaseRequest;

final class FinanceProfitCalculationRequest extends BaseRequest
{
    public function rules(): array
    {
        $uuid = $this->route('profit_calculation') ?? $this->route('id');

        return [
            'company_id' => ['required', 'integer', 'exists:companies,id'],
            'farm_id' => ['nullable', 'integer', 'exists:farms,id'],
            'culture_cycle_id' => ['nullable', 'integer', 'exists:culture_cycles,id'],
            'harvest_id' => ['nullable', 'integer', 'exists:harvests,id'],
            'cost_center_id' => ['required', 'integer', 'exists:finance_cost_centers,id'],
            'calculation_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('finance_profit_calculations', 'calculation_number')->ignore($uuid, 'uuid'),
            ],
            'calculation_date' => ['required', 'date'],
            'period_start' => ['required', 'date'],
            'period_end' => ['required', 'date', 'after_or_equal:period_start'],
            'status' => [
                'required',
                'string',
                Rule::in(['Draft', 'Completed']),
            ],
            'notes' => ['nullable', 'string'],
        ];
    }
}
