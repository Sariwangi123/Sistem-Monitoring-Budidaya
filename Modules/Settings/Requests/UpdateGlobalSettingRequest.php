<?php

namespace Modules\Settings\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateGlobalSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'key' => ['sometimes', 'string', 'max:255', Rule::unique('global_settings', 'key')->ignore($this->route('setting'))],
            'value' => ['sometimes', 'array'],
            'type' => ['sometimes', 'string', 'max:100'],
        ];
    }
}
