<?php

namespace Mpietrucha\Laravel\Package\Provider\Concerns;

use Mpietrucha\Laravel\Package\Nova\Component;
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

        Component::use($component, $this);

        return $this;
    }
}
