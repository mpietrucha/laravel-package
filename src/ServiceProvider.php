<?php

namespace Mpietrucha\Laravel\Package;

use Mpietrucha\Laravel\Package\Concerns\Provider\ProcessExternalTranslations;
use Mpietrucha\Laravel\Package\Concerns\Provider\ProcessNovaComponent;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

/**
 * @property \Mpietrucha\Laravel\Package\Builder $package
 */
abstract class ServiceProvider extends PackageServiceProvider
{
    use ProcessExternalTranslations;
    use ProcessNovaComponent;

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
        $this->bootPackageExternalTranslations();
    }

    protected function package(): Builder
    {
        return $this->package;
    }
}
