<?php

namespace Modules\Permissions\DTO;

final readonly class PermissionData
{
    public function __construct(
        public string $name,
        public string $slug,
        public ?string $description = null,
    ) {
    }
}
