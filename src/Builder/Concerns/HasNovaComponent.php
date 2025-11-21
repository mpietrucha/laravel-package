<?php

namespace Mpietrucha\Laravel\Package\Builder\Concerns;

use Mpietrucha\Laravel\Package\Nova\Enums\Component;

/**
 * @phpstan-require-extends \Mpietrucha\Laravel\Package\Builder
 */
trait HasNovaComponent
{
    protected ?Component $novaComponent = null;

    public function novaComponent(): ?Component
    {
        return $this->novaComponent;
    }

    public function hasNovaComponent(Component $component = Component::MIX): static
    {
        $this->novaComponent = $component;

        return $this;
    }
}
