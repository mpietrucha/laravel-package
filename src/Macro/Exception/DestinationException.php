<?php

namespace Mpietrucha\Laravel\Essentials\Macro\Exception;

use Mpietrucha\Utility\Throwable\InvalidArgumentException;

class DestinationException extends InvalidArgumentException
{
    public function initialize(): void
    {
        'Macro destination does not use any of the supported Macroable implementations' |> $this->message(...);
    }
}
