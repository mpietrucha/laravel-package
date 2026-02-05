<?php

namespace Mpietrucha\Laravel\Essentials\Package;

use Mpietrucha\Laravel\Essentials\Package\Context\Frame;
use Mpietrucha\Laravel\Essentials\Package\Context\Name;
use Mpietrucha\Laravel\Essentials\Package\Context\Provider;
use Mpietrucha\Utility\Backtrace;
use Mpietrucha\Utility\Enumerable\Contracts\EnumerableInterface;
use Mpietrucha\Utility\Filesystem\Path;
use Mpietrucha\Utility\Normalizer;
use Mpietrucha\Utility\Str;
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

    public static function directory(): ?string
    {
        return static::utilize() |> Str::nullWhenEmpty(...);
    }

    protected static function hydrate(): string
    {
        $backtrace = Backtrace::get();

        $directory = $backtrace->pipeThrough([
            fn (EnumerableInterface $backtrace) => Frame::internal(...) |> $backtrace->skipUntilLast(...),
            fn (EnumerableInterface $backtrace) => $backtrace->firstMap->file(),
        ]) |> Normalizer::string(...) |> Path::directory(...);

        return Str::before($directory, 'src') |> Path::canonicalize(...);
    }
}
