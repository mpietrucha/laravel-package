<?php

namespace Mpietrucha\Laravel\Package\Translations\Exception;

use Mpietrucha\Utility\Throwable\RuntimeException;

class TranslationsPackageNameException extends RuntimeException
{
    public function initialize(): void
    {
        'Unable to determine translation package name' |> $this->message(...);
    }
}
