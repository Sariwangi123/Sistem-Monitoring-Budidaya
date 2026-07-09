<?php

namespace Modules\Roles\DTO;

final readonly class RoleData
{
    public function __construct(
        public string $name,
        public string $slug,
        public ?string $description = null,
    ) {
    }
}
