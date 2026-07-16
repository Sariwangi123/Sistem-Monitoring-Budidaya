<?php

namespace Modules\Administration\Engines;

final class RestoreEngine
{
    /** @return array<string, mixed> */
    public function metadata(): array
    {
        return ['enabled' => false, 'production_operations_enabled' => false, 'restore_validation_ready' => true, 'execution_mode' => 'foundation_only', 'non_destructive_by_default' => true];
    }

    /** @return array<string, mixed> */
    public function requests(): array
    {
        return ['items' => [], 'requires_explicit_authorization' => true, 'requester_cannot_approve_own_request' => true, 'destructive_restore_executed' => false];
    }

    /** @return array<string, mixed> */
    public function validation(): array
    {
        return ['workflow' => ['authentication', 'authorization', 'scope_validation', 'backup_integrity_validation', 'compatibility_validation', 'dry_run', 'approval', 'execution_metadata', 'verification', 'audit', 'notification'], 'status' => 'metadata_ready', 'rollback_metadata' => true, 'failure_metadata' => true];
    }

    /** @return array<string, mixed> */
    public function dryRun(): array
    {
        return ['mode' => 'simulation_only', 'status' => 'not_executed', 'job' => \Modules\Administration\Jobs\RestoreDryRunJob::class, 'destructive_operation' => false, 'requires_worker_for_tests' => false, 'audit_event' => 'restore_dry_run_requested'];
    }
}
