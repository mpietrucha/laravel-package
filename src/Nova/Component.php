<?php

namespace Mpietrucha\Laravel\Package\Nova;

use Mpietrucha\Laravel\Package\Nova\Enums\Component as Type;
use Mpietrucha\Laravel\Package\ServiceProvider;
use Mpietrucha\Utility\Forward\Contracts\ForwardInterface;
use Mpietrucha\Utility\Forward\Dependency;

abstract class Component
{
    public static function use(Type $type, ServiceProvider $provider): void
    {
        $method = $type->value;

        $package = $provider->package()->basePath('../dist');

        static::dependency()->get($method, $provider->package()->tag(), $package);
    }

    protected static function dependency(): ForwardInterface
    {
        return Dependency::use('Mpietrucha\Nova\Components\Component', 'mpietrucha/nova', 'nova components');
    }
}
