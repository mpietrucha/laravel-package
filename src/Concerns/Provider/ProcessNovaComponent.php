<?php

namespace Mpietrucha\Laravel\Package\Concerns\Provider;

use Mpietrucha\Laravel\Package\Exception\NovaComponentException;
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

        Instance::unexists(Component::class) && NovaComponentException::create()->throw();

        $component = $component->value;

        Component::$component($this->package()->tag(), $this->package()->basePath('../resources/dist'));

        return $this;
    }
}
