<?php

namespace Mpietrucha\Laravel\Essentials\Macro;

use Mpietrucha\Utility\Concerns\Creatable;
use Mpietrucha\Utility\Contracts\CreatableInterface;
use Mpietrucha\Utility\Str;
use Mpietrucha\Utility\Throwable\Contracts\InteractsWithThrowableInterface;
use Mpietrucha\Utility\Type;
use Mpietrucha\Utility\Value\Contracts\ResultInterface;

class Failure implements CreatableInterface
{
    use Creatable;

    public function __construct(protected InteractsWithThrowableInterface $throwable, protected string $method)
    {
    }

    public function throw(): void
    {
        $throwable = $this->throwable();

        $this->message() |> $throwable->message(...);

        $throwable->align(5);

        $throwable->throw();
    }

    public static function handle(ResultInterface $result, string $method): void
    {
        $throwable = $result->throwable();

        if (Type::null($throwable)) {
            return;
        }

        static::create($throwable, $method)->throw();
    }

    protected function message(): string
    {
        $message = $this->throwable()->value()->getMessage() |> Str::of(...);

        $method = $this->method();

        $closure = $message->between('::', '()');

        return $message->replace($closure, $method);
    }

    protected function throwable(): InteractsWithThrowableInterface
    {
        return $this->throwable;
    }

    protected function method(): string
    {
        return $this->method;
    }
}
