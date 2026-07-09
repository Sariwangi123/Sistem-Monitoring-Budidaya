<?php

namespace MasterData\Http\Requests;

use Illuminate\Validation\Rule;

class FeedBrandRequest extends BaseRequest
{
    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'feed_brand_code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('feed_brands', 'feed_brand_code')->ignore($id),
            ],
            'feed_brand_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }
}