<?php

namespace Mpietrucha\PHPStan\Actions;

use Mpietrucha\Utility\Collection;
use Mpietrucha\Utility\Enumerable\Contracts\EnumerableInterface;
use Mpietrucha\Utility\Filesystem;
use Mpietrucha\Utility\Filesystem\Temporary;

/**
 * @internal
 *
 * @phpstan-type StorageCollection \Mpietrucha\Utility\Collection<string, string>
 */
abstract class Cache
{
    /**
     * @var null|StorageCollection
     */
    protected static ?EnumerableInterface $storage = null;

    public static function get(string $name): ?string
    {
        return static::storage()->get($name);
    }

    public static function set(string $name, string $value): void
    {
        static::storage()->put($name, $value);

        $storage = static::storage()->toJson();

        Filesystem::put(static::file(), $storage);
    }

    public static function stale(string $name, string $value): bool
    {
        if (static::get($name) === $value) {
            return false;
        }

        static::set($name, $value);

        return true;
    }

    /**
     * @return StorageCollection
     */
    protected static function storage(): EnumerableInterface
    {
        return static::$storage ??= static::file() |> Filesystem::json(...) |> Collection::create(...);
    }

    protected static function file(): string
    {
        return Temporary::file('phpstan-actions-cache.json');
    }
}
