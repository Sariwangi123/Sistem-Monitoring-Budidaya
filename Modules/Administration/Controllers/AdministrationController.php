<?php

namespace Modules\Administration\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;
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
}
