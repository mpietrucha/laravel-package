<?php

namespace Mpietrucha\Laravel\Essentials\Package\Translations;

use Mpietrucha\Laravel\Essentials\Package\Context;
use Mpietrucha\Utility\Normalizer;
use Mpietrucha\Utility\Str;
use Mpietrucha\Utility\Type;

/**
 * @phpstan-type TranslationProperties array<string, string>
 */
abstract class Translation
{
    public static function key(object|string $context, string $key): string
    {
        $name = Context::name($context);

        return Type::null($name) ? $key : Str::sprintf('%s::%s', $name, $key);
    }

    /**
     * @param  null|TranslationProperties  $properties
     */
    public static function get(object|string $context, string $key, ?array $properties = null): string
    {
        $key = static::key($context, $key);

        return __($key, static::properties($properties));
    }

    /**
     * @param  null|TranslationProperties  $properties
     */
    public static function choice(object|string $context, string $key, int $count, ?array $properties = null): string
    {
        $key = static::key($context, $key);

        return trans_choice($key, $count, static::properties($properties));
    }

    /**
     * @param  null|TranslationProperties  $properties
     * @return TranslationProperties
     */
    protected static function properties(?array $properties = null): array
    {
        return Normalizer::array($properties);  /** @phpstan-ignore return.type */
    }
}
