<?php

namespace Mpietrucha\PHPStan\Bootstrap;

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

    public static function get(string $identifier): ?string
    {
        return static::storage()->get($identifier);
    }

    public static function set(string $identifier, string $hash): void
    {
        static::storage()->put($identifier, $hash);

        $file = static::file();

        Filesystem::put($file, static::storage()->toJson());
    }

    public static function validate(string $identifier, string $hash): bool
    {
        if (static::get($identifier) === $hash) {
            return false;
        }

        static::set($identifier, $hash);

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
