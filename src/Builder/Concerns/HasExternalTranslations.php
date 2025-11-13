<?php

namespace Mpietrucha\Laravel\Package\Builder\Concerns;

/**
 * @phpstan-require-extends \Mpietrucha\Laravel\Package\Builder
 */
trait HasExternalTranslations
{
    protected ?string $externalTranslations = null;

    public function externalTranslations(): ?string
    {
        return $this->externalTranslations;
    }

    public function hasExternalTranslations(string $translations): static
    {
        $this->externalTranslations = $translations;

        return $this;
    }
}
