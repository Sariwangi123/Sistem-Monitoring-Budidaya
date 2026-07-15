<?php

namespace ReportAnalytics\Support;

final readonly class ReportDefinition
{
    /**
     * @param array<int, string> $supportedExportFormats
     * @param array<int, string> $allowedRoles
     */
    public function __construct(
        public string $id,
        public string $name,
        public string $category,
        public string $sourceModule,
        public string $template,
        public ?string $requiredPermission,
        public array $supportedExportFormats,
        public bool $scheduleSupport,
        public string $version,
        public array $allowedRoles = []
    ) {
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => $this->category,
            'source_module' => $this->sourceModule,
            'template' => $this->template,
            'required_permission' => $this->requiredPermission,
            'supported_export_formats' => $this->supportedExportFormats,
            'schedule_support' => $this->scheduleSupport,
            'version' => $this->version,
            'allowed_roles' => $this->allowedRoles,
        ];
    }
}
