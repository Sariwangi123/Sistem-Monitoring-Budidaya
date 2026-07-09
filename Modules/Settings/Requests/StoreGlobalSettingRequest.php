<?php

namespace Modules\Settings\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class StoreGlobalSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'key' => ['required', 'string', 'max:255', 'unique:global_settings,key'],
            'value' => ['required', 'array'],
            'type' => ['required', 'string', 'max:100'],
        ];
    }
}
