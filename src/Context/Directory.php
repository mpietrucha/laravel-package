<?php

namespace Mpietrucha\Laravel\Package\Context;

use Mpietrucha\Laravel\Package\Context;
use Mpietrucha\Utility\Enumerable\Contracts\EnumerableInterface;
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
            fn (EnumerableInterface $backtrace) => $backtrace->reject->internal(Context::class),
            fn (EnumerableInterface $backtrace) => $backtrace->map->file(),
            fn (EnumerableInterface $backtrace) => $backtrace->first(),
        ]) |> Normalizer::string(...);

        return Str::before($file, 'src');
    }
}
