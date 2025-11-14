<?php

namespace Mpietrucha\Laravel\Package\Provider\Concerns;

use Mpietrucha\Laravel\Package\Provider\Exception\NovaComponentException;
use Mpietrucha\Nova\Components\Component;
use Mpietrucha\Utility\Instance;
use Mpietrucha\Utility\Type;

/**
 * @phpstan-require-extends \Mpietrucha\Laravel\Package\ServiceProvider
 */
trait ProcessNovaComponent
{
    protected function bootPackageNovaComponent(): static
    {
        $component = $this->package()->novaComponent();

        if (Type::null($component)) {
            return $this;
        }

        match (true) {
            Instance::unexists(Component::class, Instance::LOAD) => NovaComponentException::create()->throw(),
            default => Component::package($component, $this->package(), 'dist')
        };

        return $this;
    }
}
