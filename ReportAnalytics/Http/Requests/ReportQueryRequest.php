<?php

namespace ReportAnalytics\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class ReportQueryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_id' => ['nullable', 'integer'],
            'farm_id' => ['nullable', 'integer'],
            'pond_id' => ['nullable', 'integer'],
            'culture_cycle_id' => ['nullable', 'integer'],
            'financial_period_id' => ['nullable', 'integer'],
            'report_category' => ['nullable', 'string', Rule::in([
                'operational',
                'production',
                'inventory',
                'harvest',
                'financial',
                'finance',
                'executive',
                'kpi',
                'audit',
                'historical',
                'comparative',
            ])],
            'date_range' => ['nullable', 'string', 'max:100'],
            'period' => ['nullable', 'string', 'max:50'],
            'search' => ['nullable', 'string', 'max:255'],
        ];
    }
}
