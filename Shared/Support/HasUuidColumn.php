<?php

namespace Shared\Support;

use Illuminate\Support\Str;

trait HasUuidColumn
{
    protected static function bootHasUuidColumn(): void
    {
        static::creating(function ($model): void {
            $model->uuid ??= (string) Str::uuid();
        });
    }
}
