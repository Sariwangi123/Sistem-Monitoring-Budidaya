<?php

namespace Activities\Http\Requests;

use Illuminate\Validation\Rule;
use MasterData\Http\Requests\BaseRequest;

final class ActivityTypeRequest extends BaseRequest
{
    public function rules(): array
    {
        $uuid = $this->route('activity_type') ?? $this->route('id');

        return [
            'event_code' => [
                'required',
                'string',
                'max:100',
                Rule::unique('activity_types', 'event_code')->ignore($uuid, 'uuid'),
            ],
            'activity_name' => ['required', 'string', 'max:255'],
            'activity_category_id' => ['required', 'integer', 'exists:activity_categories,id'],
            'icon' => ['nullable', 'string', 'max:100'],
            'color' => ['nullable', 'string', 'max:50'],
            'is_manual' => ['sometimes', 'boolean'],
            'is_system' => ['sometimes', 'boolean'],
            'status' => ['required', 'string', Rule::in(['Active', 'Inactive'])],
            'description' => ['nullable', 'string'],
        ];
    }
}
