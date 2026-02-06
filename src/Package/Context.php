<?php

namespace Mpietrucha\Laravel\Essentials\Package;

use Mpietrucha\Utility\Backtrace;
use Mpietrucha\Utility\Filesystem\Path;
use Mpietrucha\Utility\Str;
use Mpietrucha\Utility\Type;

abstract class Context
{
    protected static int $frames = 0;

    public static function directory(): ?string
    {
        $file = Backtrace::get(DEBUG_BACKTRACE_IGNORE_ARGS, static::frames())
            ->map
            ->file()
            ->last();

        if (Type::null($file)) {
            return null;
        }

        return Str::before($file, 'src') |> Path::canonicalize(...);
    }

    public static function name(): ?string
    {
        static::track();

        $directory = static::directory();

        return Type::null($directory) ? null : Path::name($directory);
    }

    protected static function track(): void
    {
        static::$frames++;
    }

    protected static function flush(): void
    {
        static::$frames = 0;
    }

    protected static function frames(): int
    {
        $frames = static::$frames;

        static::flush();

        return $frames + 2;
    }
}
