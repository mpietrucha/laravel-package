<?php

namespace Mpietrucha\Laravel\Package\Builder\Concerns;

use Mpietrucha\Laravel\Package\Builder\Enum\Nova;

/**
 * @phpstan-require-extends \Mpietrucha\Laravel\Package\Builder
 */
trait HasNovaComponent
{
    protected ?Nova $novaComponent = null;

    public function novaComponent(): ?Nova
    {
        return $this->novaComponent;
    }

    public function hasNovaComponent(Nova $component = Nova::MIX): static
    {
        $this->novaComponent = $component;

        return $this;
    }
}
