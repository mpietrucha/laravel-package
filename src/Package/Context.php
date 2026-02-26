<?php

namespace Mpietrucha\Laravel\Essentials\Package;

use Mpietrucha\Utility\Filesystem\Path;
use Mpietrucha\Utility\Instance;
use Mpietrucha\Utility\Str;
use Mpietrucha\Utility\Type;

abstract class Context
{
    public static function directory(object|string $context): ?string
    {
        $file = Instance::file($context);

        if (Type::null($file)) {
            return null;
        }

        return Str::before($file, 'src') |> Path::canonicalize(...) |> Str::nullWhenEmpty(...);
    }

    public static function name(object|string $context): ?string
    {
        $directory = static::directory($context);

        return Type::null($directory) ? null : Path::name($directory);
    }
}
