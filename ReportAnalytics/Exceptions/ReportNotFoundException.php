<?php

namespace ReportAnalytics\Exceptions;

use RuntimeException;

final class ReportNotFoundException extends RuntimeException
{
    public static function forReport(string $reportId): self
    {
        return new self("Report definition [{$reportId}] was not found.");
    }

    public function render(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
            'errors' => [],
        ], 404);
    }
}
