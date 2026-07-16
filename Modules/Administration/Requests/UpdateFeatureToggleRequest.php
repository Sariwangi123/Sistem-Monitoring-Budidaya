<?php

namespace Modules\Administration\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Administration\Support\FeatureToggle;

final class UpdateFeatureToggleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return ['state' => ['required', 'string', Rule::in([FeatureToggle::ENABLED, FeatureToggle::DISABLED, FeatureToggle::HIDDEN])]];
    }
}
