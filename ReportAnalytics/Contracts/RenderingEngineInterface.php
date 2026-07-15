<?php

namespace ReportAnalytics\Contracts;

use ReportAnalytics\Support\RenderedReport;
use ReportAnalytics\Support\ReportBuild;

interface RenderingEngineInterface
{
    public function render(ReportBuild $build): RenderedReport;
}
