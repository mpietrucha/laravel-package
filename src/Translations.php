<?php

namespace Mpietrucha\Laravel\Package;

use Mpietrucha\Laravel\Package\Translations\Builder;
use Mpietrucha\Laravel\Package\Translations\Json;
use Mpietrucha\Laravel\Package\Translations\Vendor;
use Mpietrucha\Utility\Str;

/**
 * @phpstan-import-type Publishable from \Mpietrucha\Laravel\Package\Translations\Builder
 */
abstract class Translations
{
    public static function tag(ServiceProvider $provider): string
    {
        return Str::sprintf('%s-translations', $provider->package()->tag());
    }

    /**
     * @return Publishable
     */
    public static function vendors(mixed $vendors, ServiceProvider $provider): array
    {
        return static::build(Vendor::build($vendors, $provider), $provider);
    }

    public static function json(ServiceProvider $provider): string
    {
        return Json::create($provider);
    }

    /**
     * @return Publishable
     */
    public static function build(mixed $input, ServiceProvider $provider): array
    {
        $translations = Builder::build($input, $provider);

        return $translations->all();
    }
}
