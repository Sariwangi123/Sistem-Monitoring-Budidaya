<?php

namespace Modules\Notifications\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class NotificationPreferenceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'in_app_enabled' => ['sometimes', 'boolean'],
            'reminder_enabled' => ['sometimes', 'boolean'],
            'sound_enabled' => ['sometimes', 'boolean'],
            'email_enabled' => ['sometimes', 'boolean'],
            'whatsapp_enabled' => ['sometimes', 'boolean'],
            'desktop_notification_enabled' => ['sometimes', 'boolean'],
        ];
    }
}
