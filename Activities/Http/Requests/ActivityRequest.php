<?php

namespace Activities\Http\Requests;

use MasterData\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class ActivityRequest extends BaseRequest
{
    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'company_id' => ['required', 'string', 'exists:companies,id'],
            'farm_id' => ['required', 'string', 'exists:farms,id'],
            'pond_area_id' => ['required', 'string', 'exists:pond_areas,id'],
            'pond_id' => ['required', 'string', 'exists:ponds,id'],
            'culture_cycle_id' => ['nullable', 'string', 'exists:culture_cycles,id'],
            'activity_type_id' => ['required', 'string', 'exists:activity_types,id'],
            'user_id' => ['required', 'string', 'exists:users,id'],
            'activity_date' => ['required', 'date'],
            'activity_time' => ['required', 'date_format:H:i:s'],
            'event_code' => [
                'required',
                'string',
                'max:100',
                Rule::unique('activities', 'event_code')->ignore($id),
            ],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'string', Rule::in(['Planned', 'In Progress', 'Completed', 'Cancelled'])],
            'reference_type' => ['nullable', 'string', 'max:100'],
            'reference_uuid' => ['nullable', 'string', 'uuid'],
            'metadata' => ['nullable', 'json'],
        ];
    }
}