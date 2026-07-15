<?php

namespace Modules\Notifications\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class NotificationQueryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'status' => ['nullable', 'string', Rule::in(['pending', 'sent', 'delivered', 'read', 'archived', 'failed', 'retry', 'processing'])],
            'category' => ['nullable', 'string', Rule::in(['operational', 'inventory', 'harvest', 'financial', 'executive', 'security', 'system', 'audit'])],
            'priority' => ['nullable', 'string', Rule::in(['critical', 'high', 'medium', 'low', 'information'])],
            'channel' => ['nullable', 'string', Rule::in(['in_app', 'email', 'whatsapp', 'telegram', 'push_notification', 'sms'])],
            'unread_only' => ['nullable', 'boolean'],
            'source_module' => ['nullable', 'string', 'max:100'],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
            'date_range' => ['nullable', 'string', 'max:100'],
            'search' => ['nullable', 'string', 'max:100'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', Rule::in(['created_at', 'updated_at', 'priority', 'status', 'category'])],
            'direction' => ['nullable', 'string', Rule::in(['asc', 'desc'])],
            'format' => ['nullable', 'string', Rule::in(['pdf', 'xlsx', 'csv', 'json'])],
        ];
    }
}
