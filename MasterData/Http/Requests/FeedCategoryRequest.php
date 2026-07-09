<?php

namespace MasterData\Http\Requests;

use Illuminate\Validation\Rule;

class FeedCategoryRequest extends BaseRequest
{
    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'feed_category_code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('feed_categories', 'feed_category_code')->ignore($id),
            ],
            'feed_category_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }
}