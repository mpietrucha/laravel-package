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

        Instance::unexists(Component::class, Instance::LOAD) && NovaComponentException::create()->throw();

        $output = $this->package()->basePath('../dist');

        Component::{$component->value}($this->package()->tag(), $output);

        return $this;
    }
}
