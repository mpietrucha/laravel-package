<?php

namespace Mpietrucha\Laravel\Package\Translations;

use Mpietrucha\Utility\Concerns\Stringable;
use Mpietrucha\Utility\Contracts\StringableInterface;
use Mpietrucha\Utility\Filesystem\Path;
use Mpietrucha\Utility\Value;

/**
 * @phpstan-import-type Package from \Mpietrucha\Laravel\Package\Translations\Builder
 *
 * @extends \Mpietrucha\Laravel\Package\Translations\Transformer<int, Package>
 */
class Json extends Transformer implements StringableInterface
{
    use Stringable;

    public function __invoke(string $locale): string
    {
        $package = $this->package()->basePath() |> Path::directory(...) |> static::hydrate(...);

        return Path::join($package, "$locale.json");
    }

    public function toString(): string
    {
        return $this->app()->getLocale() |> Value::for($this)->get(...);
    }
}
