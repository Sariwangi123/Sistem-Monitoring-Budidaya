<?php

namespace Modules\Settings\DTO;

final readonly class GlobalSettingData
{
    public function __construct(
        public string $key,
        public array $value,
        public string $type,
    ) {
    }
}
