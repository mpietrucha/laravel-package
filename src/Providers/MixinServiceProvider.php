<?php

namespace Mpietrucha\Laravel\Package\Providers;

use Mpietrucha\Laravel\Package\Builder;
use Mpietrucha\Laravel\Package\Commands\GenerateMixinAnalyzers;
use Mpietrucha\Laravel\Package\Commands\GenerateMixinStubs;
use Mpietrucha\Laravel\Package\ServiceProvider;

class MixinServiceProvider extends ServiceProvider
{
    public function configure(Builder $package): void
    {
        $package->name('laravel-package');

        $package->hasConsoleCommands([
            GenerateMixinStubs::class,
            GenerateMixinAnalyzers::class,
        ]);
    }
}
