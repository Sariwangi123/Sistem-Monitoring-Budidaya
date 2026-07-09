<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('utifarm:about', function (): void {
    $this->info('UtiFarm foundation is ready.');
})->purpose('Display UtiFarm foundation status');
