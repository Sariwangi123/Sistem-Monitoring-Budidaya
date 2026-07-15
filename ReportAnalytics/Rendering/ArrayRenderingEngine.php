<?php

namespace ReportAnalytics\Rendering;

use ReportAnalytics\Contracts\RenderingEngineInterface;
use ReportAnalytics\Support\RenderedReport;
use ReportAnalytics\Support\ReportBuild;

final class ArrayRenderingEngine implements RenderingEngineInterface
{
    public function render(ReportBuild $build): RenderedReport
    {
        return new RenderedReport(
            definition: $build->definition,
            template: $build->template,
            payload: [
                'rendering' => 'array',
                'read_only' => true,
                'build' => $build->toArray(),
            ]
        );
    }
}
