<?php

namespace Mpietrucha\Laravel\Package\Builder\Concerns;

use Mpietrucha\Utility\Arr;

/**
 * @phpstan-require-extends \Mpietrucha\Laravel\Package\Builder
 *
 * @phpstan-type Translations array<int, string>
 */
trait HasExternalTranslations
{
    /**
     * @var null|Translations
     */
    protected ?array $externalTranslations = null;

    /**
     * @return null|Translations
     */
    public function externalTranslations(): ?array
    {
        return $this->externalTranslations;
    }

    /**
     * @param  string|Translations  $translations
     */
    public function hasExternalTranslations(array|string $translations): static
    {
        $this->externalTranslations = Arr::wrap($translations);

        return $this;
    }
}
