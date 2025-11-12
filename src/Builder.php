<?php

namespace Mpietrucha\Laravel\Package;

use Mpietrucha\Laravel\Package\Concerns\HasExternalTranslations;
use Mpietrucha\Laravel\Package\Concerns\HasNovaComponent;
use Mpietrucha\Utility\Concerns\Creatable;
use Mpietrucha\Utility\Contracts\CreatableInterface;
use Spatie\LaravelPackageTools\Package;

class Builder extends Package implements CreatableInterface
{
    use Creatable;
    use HasExternalTranslations;
    use HasNovaComponent;

    public function tag(): string
    {
        return $this->shortName();
    }
}
