<?php

namespace Activities\Http\Requests;

use MasterData\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class ActivityCategoryRequest extends BaseRequest
{
    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('activity_categories', 'code')->ignore($id),
            ],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:100'],
            'color' => ['nullable', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ];
    }
}