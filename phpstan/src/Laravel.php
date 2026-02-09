<?php

namespace Mpietrucha\PHPStan;

use Mpietrucha\PHPStan\Bootstrap\Action;
use Mpietrucha\Utility\Constant;
use Mpietrucha\Utility\Filesystem;
use Mpietrucha\Utility\Filesystem\Path;

/**
 * @internal
 */
abstract class Laravel extends Action
{
    public static function due(): bool
    {
        return Constant::undefined('LARAVEL_START');
    }

    protected static function handle(): void
    {
        Path::build('vendor/larastan/larastan/bootstrap.php') |> Filesystem::requireOnce(...);
    }
}
