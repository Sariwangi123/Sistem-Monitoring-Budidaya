<?php

namespace Dashboard\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class DashboardQueryRequest extends FormRequest
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
            'company_id' => ['nullable', 'integer'],
            'farm_id' => ['nullable', 'integer'],
            'pond_id' => ['nullable', 'integer'],
            'culture_cycle_id' => ['nullable', 'integer'],
            'financial_period_id' => ['nullable', 'integer'],
            'date_range' => ['nullable', 'string', 'max:100'],
            'search' => ['nullable', 'string', 'max:255'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'unread_only' => ['nullable', 'boolean'],
            'severity' => ['nullable', 'string', Rule::in(['Low', 'Medium', 'High', 'Critical'])],
            'category' => ['nullable', 'string', 'max:100'],
        ];
    }
}
