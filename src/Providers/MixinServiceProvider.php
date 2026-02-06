<?php

namespace Mpietrucha\Laravel\Essentials\Providers;

use Mpietrucha\Laravel\Essentials\Commands\GenerateMixinAnalyzers;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MixinServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->hasConsoleCommand(GenerateMixinAnalyzers::class);
    }
}
