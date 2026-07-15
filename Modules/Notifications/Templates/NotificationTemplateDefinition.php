<?php

namespace Modules\Notifications\Templates;

final readonly class NotificationTemplateDefinition
{
    public function __construct(
        public string $key,
        public string $title,
        public string $message,
        public ?string $icon = null,
        public ?string $priority = null,
        public ?string $actionUrl = null
    ) {
    }

    /** @return array<string, string|null> */
    public function toArray(): array
    {
        return [
            'key' => $this->key,
            'title' => $this->title,
            'message' => $this->message,
            'icon' => $this->icon,
            'priority' => $this->priority,
            'action_url' => $this->actionUrl,
        ];
    }
}
