<?php

namespace Mpietrucha\Laravel\Package\Exception;

use Mpietrucha\Utility\Throwable\RuntimeException;

class NovaComponentException extends RuntimeException
{
    public function initialize(): void
    {
        'In order to use nova component install mpietrucha/nova package' |> $this->message(...);
    }
}
