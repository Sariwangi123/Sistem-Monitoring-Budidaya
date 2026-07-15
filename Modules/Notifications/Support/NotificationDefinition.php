<?php

namespace Modules\Notifications\Support;

final readonly class NotificationDefinition
{
    /**
     * @param array<int, string> $channels
     * @param array<int, string> $allowedRoles
     */
    public function __construct(
        public string $eventName,
        public string $notificationType,
        public string $category,
        public string $priority,
        public array $channels,
        public string $recipientStrategy,
        public string $templateKey,
        public RetryPolicy $retryPolicy,
        public string $version,
        public string $title,
        public string $message,
        public array $allowedRoles = []
    ) {
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'event_name' => $this->eventName,
            'notification_type' => $this->notificationType,
            'category' => $this->category,
            'priority' => $this->priority,
            'channels' => $this->channels,
            'recipient_strategy' => $this->recipientStrategy,
            'template' => $this->templateKey,
            'retry_policy' => $this->retryPolicy->toArray(),
            'version' => $this->version,
            'title' => $this->title,
            'message' => $this->message,
            'allowed_roles' => $this->allowedRoles,
        ];
    }
}
