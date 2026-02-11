<?php

namespace Mpietrucha\Laravel\Essentials\Mixin;

use Mpietrucha\Utility\Collection;
use Mpietrucha\Utility\Enumerable\Contracts\EnumerableInterface;
use Mpietrucha\Utility\Hash;
use Mpietrucha\Utility\Instance\Path;
use Mpietrucha\Utility\Str;
use Mpietrucha\Utility\Type;
use Mpietrucha\Utility\Value;

/**
 * @phpstan-import-type MixinCollection from \Mpietrucha\Laravel\Essentials\Mixin
 */
class Analyzer
{
    public static function stub(): string
    {
        return '<?php namespace %s; class %s extends %s { %s }';
    }

    public static function indicator(): string
    {
        $indicator = 'Analyzers';

        return $indicator . Hash::md5($indicator) . Path::delimiter();
    }

    /**
     * @param  class-string  $destination
     */
    public static function namespace(string $destination): string
    {
        $namespace = Path::namespace($destination);

        $indicator = static::indicator();

        return Path::join($indicator, $namespace);
    }

    /**
     * @param  MixinCollection  $mixins
     * @param  class-string  $destination
     */
    public static function content(string $destination, Collection $mixins): ?string
    {
        $mixins = static::mixins($mixins);

        if (Type::null($mixins)) {
            return null;
        }

        $stub = static::stub();

        $namespace = static::namespace($destination);

        $class = Path::name($destination);

        $destination = Path::canonicalize($destination);

        return Str::sprintf($stub, $namespace, $class, $destination, $mixins);
    }

    /**
     * @param  MixinCollection  $mixins
     */
    protected static function mixins(Collection $mixins): ?string
    {
        $use = Value::pipe('use %s;', Str::sprintf(...));

        $mixins = $mixins->pipeThrough([
            fn (EnumerableInterface $mixins) => Type::string(...) |> $mixins->filter(...),
            fn (EnumerableInterface $mixins) => Path::canonicalize(...) |> $mixins->map(...),
            fn (EnumerableInterface $mixins) => $mixins->map($use),
        ]);

        return Str::eol() |> $mixins->join(...) |> Str::nullWhenEmpty(...);
    }
}
