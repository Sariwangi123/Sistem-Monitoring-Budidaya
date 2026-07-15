<?php

namespace Harvest\Http\Requests;

use Illuminate\Validation\Rule;
use MasterData\Http\Requests\BaseRequest;

final class HarvestBatchRequest extends BaseRequest
{
    public function rules(): array
    {
        $uuid = $this->route('batch') ?? $this->route('harvest_batch') ?? $this->route('id');

        return [
            'harvest_id' => ['required', 'integer', 'exists:harvests,id'],
            'culture_cycle_id' => ['required', 'integer', 'exists:culture_cycles,id'],
            'batch_code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('harvest_batches', 'batch_code')->ignore($uuid, 'uuid'),
            ],
            'batch_name' => ['required', 'string', 'max:255'],
            'harvest_date' => ['required', 'date'],
            'harvest_population' => ['sometimes', 'integer', 'min:0'],
            'gross_weight' => ['sometimes', 'numeric', 'min:0'],
            'net_weight' => ['sometimes', 'numeric', 'min:0'],
            'average_weight' => ['sometimes', 'numeric', 'min:0'],
            'status' => ['required', 'string', Rule::in(['Harvesting', 'QC', 'Packing', 'Delivered', 'Completed', 'Cancelled'])],
            'notes' => ['nullable', 'string'],
        ];
    }
}
