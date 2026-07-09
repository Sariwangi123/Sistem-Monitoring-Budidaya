<?php

namespace Modules\Notifications\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateNotificationTemplateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'channel' => ['sometimes', 'string', 'in:email,push'],
            'name' => ['sometimes', 'string', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'body' => ['sometimes', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
