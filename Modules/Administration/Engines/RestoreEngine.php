<?php

namespace Modules\Administration\Engines;

final class RestoreEngine
{
    /** @return array<string, mixed> */
    public function metadata(): array
    {
        return ['enabled' => false, 'production_operations_enabled' => false, 'restore_validation_ready' => true, 'execution_mode' => 'foundation_only'];
    }
}
