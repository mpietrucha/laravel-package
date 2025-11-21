<?php

namespace Mpietrucha\Laravel\Package\Builder\Concerns;

/**
 * @phpstan-require-extends \Mpietrucha\Laravel\Package\Builder
 */
trait HasNovaTranslations
{
    protected bool $novaTranslations = false;

    public function novaTranslations(): bool
    {
        return $this->novaTranslations;
    }

    public function hasNovaTranslations(): static
    {
        $this->novaTranslations = true;

        return $this;
    }
}
