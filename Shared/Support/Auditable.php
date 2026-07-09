<?php

namespace Shared\Support;

trait Auditable
{
    protected static function bootAuditable(): void
    {
        static::creating(function ($model): void {
            $userId = auth()->id();
            $model->created_by ??= $userId;
            $model->updated_by ??= $userId;
        });

        static::updating(function ($model): void {
            $model->updated_by = auth()->id();
        });

        static::deleting(function ($model): void {
            if (method_exists($model, 'isForceDeleting') && ! $model->isForceDeleting()) {
                $model->deleted_by = auth()->id();
                $model->saveQuietly();
            }
        });
    }
}
