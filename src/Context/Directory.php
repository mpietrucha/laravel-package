<?php

namespace Mpietrucha\Laravel\Package\Context;

use Mpietrucha\Utility\Enumerable\Contracts\EnumerableInterface;
use Mpietrucha\Utility\Filesystem\Path;
use Mpietrucha\Utility\Normalizer;
use Mpietrucha\Utility\Str;

/**
 * @phpstan-import-type BacktraceFramesCollection from \Mpietrucha\Utility\Backtrace
 */
abstract class Directory
{
    /**
     * @param  BacktraceFramesCollection  $backtrace
     */
    public static function get(EnumerableInterface $backtrace): string
    {
        $file = $backtrace->pipeThrough([
            fn (EnumerableInterface $backtrace) => $backtrace->skip(2),
            fn (EnumerableInterface $backtrace) => $backtrace->firstMap->file(),
        ]) |> Normalizer::string(...);

        return Str::before($file, 'src') |> Path::canonicalize(...);
    }
}
