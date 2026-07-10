<?php

namespace Activities\Http\Requests;

use MasterData\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class ActivityCategoryRequest extends BaseRequest
{
    public function rules(): array
    {
        $uuid = $this->route('category') ?? $this->route('id');

        return [
            'category_code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('activity_categories', 'category_code')->ignore($uuid, 'uuid'),
            ],
            'category_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'string', Rule::in(['Active', 'Inactive'])],
        ];
    }
}
