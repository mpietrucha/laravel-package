<?php

namespace Mpietrucha\PHPStan;

use Illuminate\Support\Facades\Artisan;
use Mpietrucha\Laravel\Essentials\Mixin;
use Mpietrucha\PHPStan\Bootstrap\Action;
use Mpietrucha\PHPStan\Bootstrap\Cache;

/**
 * @internal
 */
abstract class MixinAnalyzers extends Action
{
    public static function due(): bool
    {
        return Cache::validate('mixins', Mixin::map()->hash());
    }

    protected static function handle(): void
    {
        Artisan::call('mixin:analyzers');
    }
}
