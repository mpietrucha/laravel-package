<?php

namespace Mpietrucha\PHPStan\Actions;

use Illuminate\Support\Facades\Artisan;
use Mpietrucha\Laravel\Essentials\Mixin;

/**
 * @internal
 */
abstract class MixinAnalyzers extends Action
{
    public static function due(): bool
    {
        return Cache::stale('mixins', Mixin::map()->hash());
    }

    protected static function handle(): void
    {
        Artisan::call('mixin:analyzers');
    }
}
