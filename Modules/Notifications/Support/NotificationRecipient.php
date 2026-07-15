<?php

namespace Modules\Notifications\Support;

final readonly class NotificationRecipient
{
    public function __construct(
        public string $type,
        public string $identifier,
        public ?string $displayName = null
    ) {
    }

    /** @return array<string, string|null> */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'identifier' => $this->identifier,
            'display_name' => $this->displayName,
        ];
    }
}
