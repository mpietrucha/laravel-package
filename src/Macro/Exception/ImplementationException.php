<?php

namespace Mpietrucha\Laravel\Essentials\Macro\Exception;

use Mpietrucha\Utility\Throwable\InvalidArgumentException;

class ImplementationException extends InvalidArgumentException
{
    public function initialize(): void
    {
        'Macro implementation must define macro method' |> $this->message(...);
    }
}
