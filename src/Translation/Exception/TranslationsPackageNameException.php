<?php

namespace Mpietrucha\Laravel\Package\Translation\Exception;

use Mpietrucha\Utility\Throwable\RuntimeException;

class TranslationsPackageNameException extends RuntimeException
{
    public function initialize(): void
    {
        'Unable to determine translation package name' |> $this->message(...);
    }
}
