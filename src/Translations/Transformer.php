<?php

namespace Mpietrucha\Laravel\Package\Translations;

use Illuminate\Contracts\Foundation\Application;
use Mpietrucha\Laravel\Package\Builder;
use Mpietrucha\Laravel\Package\ServiceProvider;
use Mpietrucha\Utility\Collection;
use Mpietrucha\Utility\Concerns\Creatable;
use Mpietrucha\Utility\Contracts\CreatableInterface;
use Mpietrucha\Utility\Enumerable\Contracts\EnumerableInterface;
use Mpietrucha\Utility\Filesystem\Path;

/**
 * @template TValue of mixed
 * @template TKey of array-key
 */
abstract class Transformer implements CreatableInterface
{
    use Creatable;

    public function __construct(protected ServiceProvider $provider)
    {
    }

    /**
     * @return \Mpietrucha\Utility\Enumerable\Contracts\EnumerableInterface<TKey, TValue>
     */
    public static function build(mixed $input, ServiceProvider $provider): EnumerableInterface
    {
        $input = static::create($provider) |> Collection::bind($input)->map(...);

        return $input->collapse();
    }

    protected function provider(): ServiceProvider
    {
        return $this->provider;
    }

    protected function package(): Builder
    {
        return $this->provider()->package();
    }

    protected function app(): Application
    {
        return $this->provider()->app();
    }

    protected function tag(): string
    {
        return $this->package()->tag();
    }

    protected static function hydrate(string $directory): string
    {
        return Path::build('resources/lang', $directory);
    }
}
