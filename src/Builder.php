<?php

namespace Mpietrucha\Laravel\Package;

use Mpietrucha\Laravel\Package\Builder\Concerns\HasExternalTranslations;
use Mpietrucha\Laravel\Package\Builder\Concerns\HasNovaComponent;
use Mpietrucha\Utility\Concerns\Creatable;
use Mpietrucha\Utility\Contracts\CreatableInterface;
use Spatie\LaravelPackageTools\Package;

class Builder extends Package implements CreatableInterface
{
    use Creatable, HasExternalTranslations, HasNovaComponent;

    public function tag(): string
    {
        return $this->shortName();
    }
}
