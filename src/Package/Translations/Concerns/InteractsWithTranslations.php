<?php

namespace Mpietrucha\Laravel\Essentials\Package\Translations\Concerns;

use Mpietrucha\Laravel\Essentials\Package\Context;
use Mpietrucha\Laravel\Essentials\Package\Translations\Exception\TranslationPackageException;
use Mpietrucha\Utility\Normalizer;
use Mpietrucha\Utility\Str;

trait InteractsWithTranslations
{
    /**
     * @param  null|array<string, string>  $properties
     */
    public static function __(string $key, ?array $properties = null): string
    {
        $name = Context::name() ?? TranslationPackageException::create()->throw();

        $key = Str::sprintf('%s::%s', $name, $key);

        return __($key, Normalizer::array($properties)); /** @phpstan-ignore argument.type */
    }
}
