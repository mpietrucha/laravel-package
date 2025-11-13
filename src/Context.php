<?php

namespace Mpietrucha\Laravel\Package;

use Mpietrucha\Laravel\Package\Context\Directory;
use Mpietrucha\Laravel\Package\Context\Name;
use Mpietrucha\Laravel\Package\Context\Provider;
use Mpietrucha\Utility\Backtrace;
use Mpietrucha\Utility\Utilizer\Concerns\Utilizable;
use Mpietrucha\Utility\Utilizer\Contracts\UtilizableInterface;

abstract class Context implements UtilizableInterface
{
    use Utilizable\Strings;

    public static function name(): ?string
    {
        return Name::get();
    }

    public static function provider(): ?string
    {
        return Provider::get();
    }

    public static function directory(): string
    {
        return static::utilize();
    }

    protected static function hydrate(): string
    {
        return Backtrace::get() |> Directory::get(...);
    }
}
