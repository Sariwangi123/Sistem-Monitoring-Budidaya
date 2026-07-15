<?php

namespace ReportAnalytics\Exceptions;

use RuntimeException;

final class InvalidReportTemplateException extends RuntimeException
{
    public static function forTemplate(string $template): self
    {
        return new self("Report template [{$template}] is invalid.");
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
