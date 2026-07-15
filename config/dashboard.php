<?php

return [
    'cache' => [
        'ttl_seconds' => (int) env('DASHBOARD_CACHE_TTL_SECONDS', 60),
        'critical_ttl_seconds' => (int) env('DASHBOARD_CRITICAL_CACHE_TTL_SECONDS', 30),
    ],
];
