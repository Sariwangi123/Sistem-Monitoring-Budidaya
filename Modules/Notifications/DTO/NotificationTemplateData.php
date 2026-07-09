<?php

namespace Modules\Notifications\DTO;

final readonly class NotificationTemplateData
{
    public function __construct(
        public string $channel,
        public string $name,
        public string $body,
        public ?string $subject = null,
        public bool $isActive = true,
    ) {
    }
}
