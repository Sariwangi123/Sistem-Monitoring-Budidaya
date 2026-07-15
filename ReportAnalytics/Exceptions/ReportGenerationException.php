<?php

namespace ReportAnalytics\Exceptions;

use RuntimeException;
use Throwable;

final class ReportGenerationException extends RuntimeException
{
    public static function failed(string $reportId, ?Throwable $previous = null): self
    {
        return new self("Report generation failed for [{$reportId}].", previous: $previous);
    }

    public function render(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
            'errors' => [],
        ], 500);
    }
}
