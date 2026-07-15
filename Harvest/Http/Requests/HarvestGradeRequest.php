<?php

namespace Harvest\Http\Requests;

use Illuminate\Validation\Rule;
use MasterData\Http\Requests\BaseRequest;

final class HarvestGradeRequest extends BaseRequest
{
    public function rules(): array
    {
        $uuid = $this->route('grade') ?? $this->route('harvest_grade') ?? $this->route('id');

        return [
            'harvest_id' => ['required', 'integer', 'exists:harvests,id'],
            'harvest_batch_id' => ['required', 'integer', 'exists:harvest_batches,id'],
            'grade_code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('harvest_grades', 'grade_code')
                    ->where('harvest_batch_id', $this->input('harvest_batch_id'))
                    ->ignore($uuid, 'uuid'),
            ],
            'grade_name' => ['required', 'string', 'max:255'],
            'fish_count' => ['sometimes', 'integer', 'min:0'],
            'total_weight' => ['sometimes', 'numeric', 'min:0'],
            'average_weight' => ['sometimes', 'numeric', 'min:0'],
            'quality_status' => ['required', 'string', Rule::in(['Accepted', 'Hold', 'Rejected'])],
            'notes' => ['nullable', 'string'],
        ];
    }
}
