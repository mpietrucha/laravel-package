<?php

namespace Mpietrucha\Laravel\Package\Exception;

use Mpietrucha\Utility\Throwable\RuntimeException;

class ExternalTranslationsException extends RuntimeException
{
    public function configure(string $translations): string
    {
        return 'Translations path `%s` does not exists';
    }
}
