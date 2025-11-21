<?php

namespace Mpietrucha\Laravel\Package;

use Illuminate\Contracts\Foundation\Application;
use Mpietrucha\Laravel\Package\Provider\Concerns\ProcessExternalTranslations;
use Mpietrucha\Laravel\Package\Provider\Concerns\ProcessNovaComponent;
use Mpietrucha\Laravel\Package\Provider\Concerns\ProcessNovaTranslations;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

/**
 * @property \Mpietrucha\Laravel\Package\Builder $package
 */
abstract class ServiceProvider extends PackageServiceProvider
{
    use ProcessExternalTranslations;
    use ProcessNovaComponent;
    use ProcessNovaTranslations;

    abstract public function configure(Builder $package): void;

    /**
     * @param  \Mpietrucha\Laravel\Package\Builder  $package
     */
    public function configurePackage(Package $package): void
    {
        $this->configure($package);
    }

    public function newPackage(): Builder
    {
        return Builder::create();
    }

    public function bootingPackage(): void
    {
        $this->bootPackageNovaComponent();
        $this->bootPackageNovaTranslations();
        $this->bootPackageExternalTranslations();
    }

    public function package(): Builder
    {
        return $this->package;
    }

    public function app(): Application
    {
        return $this->app;
    }
}
