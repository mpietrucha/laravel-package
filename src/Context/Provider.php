<?php

namespace Mpietrucha\Laravel\Package\Context;

use Mpietrucha\Laravel\Package\Context;
use Mpietrucha\Laravel\Package\Context\Concerns\InteractsWithCache;
use Mpietrucha\Utility\Filesystem;
use Mpietrucha\Utility\Filesystem\Path;
use Mpietrucha\Utility\Finder;
use Mpietrucha\Utility\Normalizer;
use Mpietrucha\Utility\Utilizer\Concerns\Utilizable;
use Mpietrucha\Utility\Utilizer\Contracts\UtilizableInterface;

abstract class Provider implements UtilizableInterface
{
    use InteractsWithCache, Utilizable\Strings;

    public static function name(): string
    {
        return static::utilize();
    }

    public static function get(): ?string
    {
        $directory = Context::directory();

        if ($provider = static::cache()->get($directory)) {
            return $provider;
        }

        static::cache()->put($directory, $provider = static::build($directory));

        return $provider;
    }

    protected static function build(string $directory): ?string
    {
        return static::default($directory) ?? static::default($directory, 'Providers') ?? static::find($directory);
    }

    protected static function default(string $directory, ?string $intermediate = null): ?string
    {
        $directory = Path::join($directory, Normalizer::string($intermediate));

        $file = Path::build(static::name(), $directory);

        return Filesystem::exists($file) ? $file : null;
    }

    protected static function find(string $directory): ?string
    {
        $finder = '*' . static::name() |> Finder::create($directory)->name(...);

        return $finder->ignoreVCSIgnored(true)
            ->files()
            ->get()
            ->first();
    }

    protected static function hydrate(): string
    {
        return 'ServiceProvider.php';
    }
}
