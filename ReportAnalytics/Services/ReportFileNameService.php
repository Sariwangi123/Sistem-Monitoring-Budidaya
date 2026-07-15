<?php

namespace ReportAnalytics\Services;

final class ReportFileNameService
{
    public function make(string $reportType, string $format, ?\DateTimeInterface $dateTime = null): string
    {
        $dateTime ??= new \DateTimeImmutable();
        $normalizedType = str($reportType)->upper()->replace([' ', '_'], '-')->toString();

        return sprintf('%s-%s.%s', $normalizedType, $dateTime->format('Ymd-His'), strtolower($format));
    }
}
