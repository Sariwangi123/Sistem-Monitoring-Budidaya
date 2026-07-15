<?php

namespace ReportAnalytics\Formatters;

final class ReportDataFormatter
{
    public function date(\DateTimeInterface $date, string $locale = 'id'): string
    {
        return $date->format($locale === 'id' ? 'd/m/Y' : 'Y-m-d');
    }

    public function number(int|float $value, string $locale = 'id'): string
    {
        return number_format($value, 2, $locale === 'id' ? ',' : '.', $locale === 'id' ? '.' : ',');
    }

    public function currency(int|float $value, string $locale = 'id', string $currency = 'IDR'): string
    {
        $prefix = $currency === 'IDR' ? 'Rp ' : $currency.' ';

        return $prefix.$this->number($value, $locale);
    }

    public function percentage(int|float $value, string $locale = 'id'): string
    {
        return $this->number($value, $locale).'%';
    }

    /** @param array<int, array<string, mixed>> $rows */
    public function table(array $rows): array
    {
        return [
            'columns' => array_keys($rows[0] ?? []),
            'rows' => $rows,
            'total_rows' => count($rows),
        ];
    }
}
