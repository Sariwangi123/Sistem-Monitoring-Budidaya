<?php

namespace Harvest\Http\Requests;

use Illuminate\Validation\Rule;
use MasterData\Http\Requests\BaseRequest;

final class HarvestPackingRequest extends BaseRequest
{
    public function rules(): array
    {
        $uuid = $this->route('packing') ?? $this->route('harvest_packing') ?? $this->route('id');

        return [
            'harvest_id' => ['required', 'integer', 'exists:harvests,id'],
            'harvest_batch_id' => ['required', 'integer', 'exists:harvest_batches,id'],
            'harvest_grade_id' => ['nullable', 'integer', 'exists:harvest_grades,id'],
            'operator_user_id' => ['required', 'integer', 'exists:users,id'],
            'packing_code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('harvest_packings', 'packing_code')->ignore($uuid, 'uuid'),
            ],
            'packing_date' => ['required', 'date'],
            'package_type' => ['required', 'string', 'max:255'],
            'package_quantity' => ['sometimes', 'integer', 'min:0'],
            'net_weight' => ['sometimes', 'numeric', 'min:0'],
            'gross_weight' => ['sometimes', 'numeric', 'min:0'],
            'status' => ['required', 'string', Rule::in(['Draft', 'Packing', 'Packed', 'Delivered', 'Cancelled'])],
            'notes' => ['nullable', 'string'],
        ];
    }
}
