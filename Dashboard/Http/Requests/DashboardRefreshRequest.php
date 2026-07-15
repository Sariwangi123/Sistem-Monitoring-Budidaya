<?php

namespace Dashboard\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class DashboardRefreshRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'workspace' => ['nullable', 'string', Rule::in([
                'executive',
                'production',
                'inventory',
                'harvest',
                'finance',
                'system',
                'administration',
            ])],
            'period' => ['nullable', 'string', 'max:50'],
        ];
    }
}
