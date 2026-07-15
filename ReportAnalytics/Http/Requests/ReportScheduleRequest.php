<?php

namespace ReportAnalytics\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class ReportScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'report_id' => ['required', 'string', Rule::in([
                'executive-summary',
                'operational-activity',
                'production-performance',
                'inventory-stock',
                'harvest-summary',
                'financial-performance',
                'kpi-scorecard',
                'audit-trail',
            ])],
            'frequency' => ['required', 'string', Rule::in(['daily', 'weekly', 'monthly', 'quarterly', 'yearly'])],
            'export_format' => ['required', 'string', Rule::in(['pdf', 'xlsx', 'csv', 'json'])],
            'timezone' => ['nullable', 'string', 'max:100'],
            'filters' => ['nullable', 'array'],
        ];
    }
}
