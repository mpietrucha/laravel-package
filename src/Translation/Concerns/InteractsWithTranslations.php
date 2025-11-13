<?php

namespace Mpietrucha\Laravel\Package\Translation\Concerns;

use Mpietrucha\Laravel\Package\Context;
use Mpietrucha\Laravel\Package\Translation\Exception\TranslationsPackageNameException;
use Mpietrucha\Utility\Normalizer;
use Mpietrucha\Utility\Str;

trait InteractsWithTranslations
{
    /**
     * @param  null|array<string, string>  $properties
     */
    public static function __(string $key, ?array $properties = null): string
    {
        $key = Str::sprintf('%s::%s', static::translationsPackageName(), $key);

        return __($key, Normalizer::array($properties)) /** @phpstan-ignore argument.type */;
    }

    protected static function translationsPackageName(): string
    {
        return Context::name() ?? TranslationsPackageNameException::create()->throw();
    }
}
