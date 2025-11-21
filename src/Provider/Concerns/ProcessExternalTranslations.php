<?php

namespace Mpietrucha\Laravel\Package\Provider\Concerns;

use Mpietrucha\Laravel\Package\Translations;
use Mpietrucha\Utility\Type;

/**
 * @phpstan-require-extends \Mpietrucha\Laravel\Package\ServiceProvider
 */
trait ProcessExternalTranslations
{
    public function bootPackageExternalTranslations(): static
    {
        $translations = $this->package()->externalTranslations();

        if (Type::null($translations)) {
            return $this;
        }

        $this->publishes(Translations::vendors($translations, $this), Translations::tag($this));

        return $this;
    }
}
