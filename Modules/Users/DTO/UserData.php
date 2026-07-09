<?php

namespace Modules\Users\DTO;

final readonly class UserData
{
    public function __construct(
        public string $name,
        public string $email,
        public bool $isActive = true,
    ) {
    }
}
