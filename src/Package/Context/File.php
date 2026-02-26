<?php

namespace Mpietrucha\Laravel\Essentials\Package\Context;

use Mpietrucha\Laravel\Essentials\EssentialsServiceProvider;
use Mpietrucha\Utility\Normalizer;
use Mpietrucha\Utility\Str;

abstract class File
{
    public static function internal(string $file): bool
    {
        return Str::contains($file, EssentialsServiceProvider::name());
    }

    final public static function external(string $file): bool
    {
        return static::internal($file) |> Normalizer::not(...);
    }
}
