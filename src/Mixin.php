<?php

namespace Mpietrucha\Laravel\Essentials;

use Mpietrucha\Laravel\Essentials\Concerns\InteractsWithMap;
use Mpietrucha\Laravel\Essentials\Mixin\Exception\MixinException;
use Mpietrucha\Laravel\Essentials\Mixin\Expression;
use Mpietrucha\Utility\Collection;
use Mpietrucha\Utility\Concerns\Compatible;
use Mpietrucha\Utility\Concerns\Creatable;
use Mpietrucha\Utility\Contracts\CompatibleInterface;
use Mpietrucha\Utility\Contracts\CreatableInterface;
use Mpietrucha\Utility\Enumerable\Contracts\EnumerableInterface;
use Mpietrucha\Utility\Filesystem;
use Mpietrucha\Utility\Filesystem\Temporary;
use Mpietrucha\Utility\Instance;
use Mpietrucha\Utility\Reflection;
use Mpietrucha\Utility\Reflection\Contracts\ReflectionInterface;
use Mpietrucha\Utility\Type;
use Mpietrucha\Utility\Value;

/**
 * @phpstan-type MixinCollection \Mpietrucha\Utility\Collection<int, object|class-string>
 * @phpstan-type MapCollection \Mpietrucha\Utility\Collection<class-string, MixinCollection>
 *
 * @method static MapCollection map()
 */
class Mixin implements CompatibleInterface, CreatableInterface
{
    use Compatible, Creatable, InteractsWithMap;

    public function __construct(protected object $handler)
    {
    }

    /**
     * @param  object|class-string  $handler
     */
    public static function build(object|string $handler): static
    {
        static::incompatible($handler) && MixinException::create()->throw();

        if (Type::object($handler)) {
            return static::create($handler);
        }

        $file = Temporary::get($handler);

        if (Filesystem::unexists($file)) {
            Filesystem::put($file, Expression::generate($handler));
        }

        return Filesystem::requireOnce($file) |> static::create(...);
    }

    /**
     * @param  class-string  $destination
     * @param  object|class-string  $handler
     */
    public static function use(string $destination, object|string $handler): void
    {
        $mixin = static::build($handler);

        $macro = Macro::use(...);

        Value::pipe($destination, $macro) |> $mixin->macros()->eachKeys(...);

        static::store($destination, $handler);
    }

    public function get(): object
    {
        return $this->handler;
    }

    protected function reflection(): ReflectionInterface
    {
        return $this->get() |> Reflection::create(...);
    }

    /**
     * @return \Mpietrucha\Utility\Enumerable\Contracts\EnumerableInterface<int, callable>
     */
    protected function macros(): EnumerableInterface
    {
        $methods = $this->reflection()->getMethods();

        return Collection::create($methods)->pipeThrough([
            fn (EnumerableInterface $methods) => $methods->filter->isPublic(),
            fn (EnumerableInterface $methods) => $methods->keyBy->getName(),
            fn (EnumerableInterface $methods) => $this->get() |> $methods->map->getClosure(...),
        ]);
    }

    protected static function compatibility(object|string $handler): bool
    {
        if (Type::object($handler)) {
            return true;
        }

        return Instance::trait($handler);
    }
}
