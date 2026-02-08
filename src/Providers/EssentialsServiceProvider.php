<?php

namespace Mpietrucha\Laravel\Essentials\Providers;

use Mpietrucha\Laravel\Essentials\Commands\GenerateIdeHelper;
use Mpietrucha\Laravel\Essentials\Commands\GenerateMixinAnalyzers;
use Mpietrucha\Laravel\Essentials\Package\Builder;
use Mpietrucha\Laravel\Essentials\Package\ServiceProvider;

class EssentialsServiceProvider extends ServiceProvider
{
    public function configure(Builder $package): void
    {
        $package->name('laravel-essentials');

        $package->hasConsoleCommands([
            GenerateIdeHelper::class,
            GenerateMixinAnalyzers::class,
        ]);
    }
}
