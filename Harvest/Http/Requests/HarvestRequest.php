<?php

namespace Harvest\Http\Requests;

use Illuminate\Validation\Rule;
use MasterData\Http\Requests\BaseRequest;

final class HarvestRequest extends BaseRequest
{
    public function rules(): array
    {
        $uuid = $this->route('harvest') ?? $this->route('id');

        return [
            'company_id' => ['required', 'integer', 'exists:companies,id'],
            'farm_id' => ['required', 'integer', 'exists:farms,id'],
            'pond_area_id' => ['required', 'integer', 'exists:pond_areas,id'],
            'pond_id' => ['required', 'integer', 'exists:ponds,id'],
            'culture_cycle_id' => ['required', 'integer', 'exists:culture_cycles,id'],
            'customer_id' => ['nullable', 'integer', 'exists:customers,id'],
            'responsible_user_id' => ['required', 'integer', 'exists:users,id'],
            'activity_id' => ['nullable', 'integer', 'exists:activities,id'],
            'harvest_code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('harvests', 'harvest_code')->ignore($uuid, 'uuid'),
            ],
            'harvest_name' => ['required', 'string', 'max:255'],
            'harvest_type' => ['required', 'string', Rule::in(['Partial Harvest', 'Final Harvest', 'Emergency Harvest'])],
            'planned_harvest_date' => ['nullable', 'date'],
            'harvest_date' => ['required', 'date'],
            'started_at' => ['nullable', 'date'],
            'completed_at' => ['nullable', 'date', 'after_or_equal:started_at'],
            'estimated_population' => ['nullable', 'integer', 'min:0'],
            'estimated_biomass' => ['sometimes', 'numeric', 'min:0'],
            'total_harvest_population' => ['sometimes', 'integer', 'min:0'],
            'total_harvest_weight' => ['sometimes', 'numeric', 'min:0'],
            'average_weight' => ['sometimes', 'numeric', 'min:0'],
            'survival_rate' => ['nullable', 'numeric', 'min:0'],
            'feed_conversion_ratio' => ['nullable', 'numeric', 'min:0'],
            'average_daily_gain' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'string', Rule::in(['Planning', 'Scheduled', 'Ready', 'Harvesting', 'QC', 'Packing', 'Delivered', 'Completed', 'Closed', 'Cancelled'])],
            'notes' => ['nullable', 'string'],
        ];
    }
}
