<?php

namespace Harvest\Http\Requests;

use Illuminate\Validation\Rule;
use MasterData\Http\Requests\BaseRequest;

final class HarvestQualityControlRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'harvest_id' => ['required', 'integer', 'exists:harvests,id'],
            'harvest_batch_id' => ['required', 'integer', 'exists:harvest_batches,id'],
            'qc_user_id' => ['required', 'integer', 'exists:users,id'],
            'qc_date' => ['required', 'date'],
            'average_weight' => ['sometimes', 'numeric', 'min:0'],
            'fish_size' => ['nullable', 'string', 'max:255'],
            'fish_condition' => ['nullable', 'string', 'max:255'],
            'damage_rate' => ['sometimes', 'numeric', 'min:0'],
            'qc_status' => ['required', 'string', Rule::in(['Passed', 'Conditional', 'Rejected'])],
            'qc_notes' => ['nullable', 'string'],
        ];
    }
}
