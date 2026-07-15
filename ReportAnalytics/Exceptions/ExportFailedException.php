<?php

namespace ReportAnalytics\Exceptions;

use RuntimeException;
use Throwable;

final class ExportFailedException extends RuntimeException
{
    public static function forFormat(string $format, ?Throwable $previous = null): self
    {
        return new self("Report export failed for format [{$format}].", previous: $previous);
    }

    public function render(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
            'errors' => [],
        ], 422);
    }
}
