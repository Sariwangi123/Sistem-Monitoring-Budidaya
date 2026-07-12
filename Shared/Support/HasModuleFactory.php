<?php

declare(strict_types=1);

namespace Shared\Support;

use Illuminate\Database\Eloquent\Factories\HasFactory;

trait HasModuleFactory
{
    use HasFactory {
        HasFactory::newFactory as private __newFactory;
    }

    /**
     * Resolve the factory class for the model.
     * Module models are in MasterData\Models, CultureCycle\Models, etc.
     * Factories are in Database\Factories\MasterData, Database\Factories\CultureCycle, etc.
     */
    protected static function newFactory()
    {
        $reflect = new \ReflectionClass(static::class);
        $shortName = $reflect->getShortName();
        $namespace = $reflect->getNamespaceName();
        $module = substr($namespace, 0, (int) strpos($namespace, '\\'));

        $factoryClass = "Database\\Factories\\{$module}\\{$shortName}Factory";

        return $factoryClass::new();
    }
}