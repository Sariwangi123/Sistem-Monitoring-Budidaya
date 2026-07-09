<?php

namespace MasterData\Http\Requests;

use Illuminate\Validation\Rule;

class FeedTypeRequest extends BaseRequest
{
    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'feed_brand_id' => ['required', 'integer', 'exists:feed_brands,id'],
            'feed_category_id' => ['required', 'integer', 'exists:feed_categories,id'],
            'feed_type_code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('feed_types', 'feed_type_code')->ignore($id),
            ],
            'feed_type_name' => ['required', 'string', 'max:255'],
            'protein_content' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'fat_content' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'fiber_content' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'moisture' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'ash_content' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'pellet_size' => ['nullable', 'numeric', 'min:0'],
            'packaging_size' => ['nullable', 'numeric', 'min:0'],
            'packaging_unit_id' => ['nullable', 'integer', 'exists:units,id'],
            'description' => ['nullable', 'string'],
        ];
    }
}