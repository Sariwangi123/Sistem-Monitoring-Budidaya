<?php

namespace ReportAnalytics\Exceptions;

use RuntimeException;

final class ReportPermissionException extends RuntimeException
{
    public static function forReport(string $reportId): self
    {
        return new self("Current user is not allowed to process report [{$reportId}].");
    }

    public function render(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
            'errors' => [],
        ], 403);
    }
}
