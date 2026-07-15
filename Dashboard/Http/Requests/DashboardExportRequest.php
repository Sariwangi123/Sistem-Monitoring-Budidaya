<?php

namespace Dashboard\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class DashboardExportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'format' => ['required', 'string', Rule::in(['pdf', 'excel', 'csv'])],
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
        ];
    }
}
