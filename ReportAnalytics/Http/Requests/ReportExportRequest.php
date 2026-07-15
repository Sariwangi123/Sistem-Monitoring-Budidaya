<?php

namespace ReportAnalytics\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class ReportExportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'format' => ['nullable', 'string', Rule::in(['pdf', 'xlsx', 'csv', 'json'])],
            'locale' => ['nullable', 'string', Rule::in(['id', 'en'])],
        ];
    }
}
