<?php

namespace ReportAnalytics\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class ReportGenerateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'report_type' => ['required', 'string', Rule::in([
                'executive-summary',
                'operational-activity',
                'production-performance',
                'inventory-stock',
                'harvest-summary',
                'financial-performance',
                'kpi-scorecard',
                'audit-trail',
            ])],
            'template' => ['nullable', 'string', 'max:100'],
            'export_format' => ['required', 'string', Rule::in(['pdf', 'xlsx', 'csv', 'json'])],
            'locale' => ['nullable', 'string', Rule::in(['id', 'en'])],
            'filter' => ['nullable', 'array'],
            'filter.company_id' => ['nullable', 'integer'],
            'filter.farm_id' => ['nullable', 'integer'],
            'filter.pond_id' => ['nullable', 'integer'],
            'filter.culture_cycle_id' => ['nullable', 'integer'],
            'filter.financial_period_id' => ['nullable', 'integer'],
            'filter.date_range' => ['nullable', 'string', 'max:100'],
            'filter.period' => ['nullable', 'string', 'max:50'],
            'parameter' => ['nullable', 'array'],
        ];
    }
}
