<?php

namespace Modules\Administration\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;
use Modules\Administration\Requests\UpdateConfigurationRequest;
use Modules\Administration\Requests\UpdateFeatureToggleRequest;
use Modules\Administration\Resources\AdministrationApiResource;
use Modules\Administration\Resources\AdministrationOverviewResource;
use Modules\Administration\Services\AdministrationService;

final class AdministrationController
{
    public function __construct(private readonly AdministrationService $administration)
    {
    }

    public function overview(): JsonResource
    {
        Gate::authorize('view-administration');

        return new AdministrationOverviewResource($this->administration->overview());
    }

    public function configurations(): JsonResource { return $this->response('configurations'); }
    public function configuration(string $key): JsonResource { return $this->response('configuration', $key); }
    public function updateConfiguration(UpdateConfigurationRequest $request, string $key): JsonResource { return $this->response('updateConfiguration', $key, $request->validated()); }
    public function configurationVersions(string $key): JsonResource { return $this->response('configurationVersions', $key); }
    public function configurationHistory(string $key): JsonResource { return $this->response('configurationHistory', $key); }
    public function configurationPublish(string $key): JsonResource { return $this->response('configurationPublish', $key); }
    public function configurationRollback(string $key): JsonResource { return $this->response('configurationRollback', $key); }
    public function configurationRefresh(string $key): JsonResource { return $this->response('configurationRefresh', $key); }
    public function modules(): JsonResource { return $this->response('modules'); }
    public function module(string $module): JsonResource { return $this->response('modules', $module); }
    public function features(): JsonResource { return $this->response('features'); }
    public function updateFeature(UpdateFeatureToggleRequest $request, string $feature): JsonResource { return $this->response('features', $feature, $request->validated('state')); }
    public function health(): JsonResource { return $this->response('health'); }
    public function healthCheck(string $check): JsonResource { return $this->response('health', $check); }
    public function security(): JsonResource { return $this->response('security'); }
    public function securitySection(string $section): JsonResource { return $this->response('security', $section); }
    public function monitoring(): JsonResource { return $this->response('monitoring'); }
    public function monitoringCheck(string $check): JsonResource { return $this->response('monitoring', $check); }
    public function monitoringSummary(): JsonResource { return $this->response('monitoringSummary'); }
    public function performance(): JsonResource { return $this->response('performance'); }
    public function capacity(): JsonResource { return $this->response('capacity'); }
    public function alerts(): JsonResource { return $this->response('alerts'); }
    public function audit(): JsonResource { return $this->response('audit'); }
    public function auditStatistics(): JsonResource { return $this->response('audit', true); }
    public function auditCenter(): JsonResource { return $this->response('auditCenter'); }
    public function healthScore(): JsonResource { return $this->response('healthScore'); }
    public function operationalDashboard(): JsonResource { return $this->response('operationalDashboard'); }
    public function backup(): JsonResource { return $this->response('backup'); }
    public function backupHistory(): JsonResource { return $this->response('backup', true); }
    public function integration(): JsonResource { return $this->response('integration'); }

    private function response(string $method, mixed ...$arguments): JsonResource
    {
        Gate::authorize('view-administration');

        return new AdministrationApiResource($this->administration->{$method}(...$arguments));
    }
}
