<?php

namespace Mpietrucha\PHPStan;

/**
 * @internal
 */
abstract class Action
{
    abstract public static function due(): bool;

    public static function run(): void
    {
        static::due() && static::handle();
    }

    abstract protected static function handle(): void;
}
