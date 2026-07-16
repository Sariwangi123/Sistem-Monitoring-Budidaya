<?php

namespace Modules\Administration\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateConfigurationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return ['enabled' => ['nullable', 'boolean'], 'values' => ['nullable', 'array']];
    }
}
