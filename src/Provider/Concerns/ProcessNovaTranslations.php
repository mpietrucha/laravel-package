<?php

namespace Mpietrucha\Laravel\Package\Provider\Concerns;

use Mpietrucha\Laravel\Package\Translations;
use Mpietrucha\Utility\Forward\Dependency;
use Mpietrucha\Utility\Normalizer;

/**
 * @phpstan-require-extends \Mpietrucha\Laravel\Package\ServiceProvider
 */
trait ProcessNovaTranslations
{
    protected function bootPackageNovaTranslations(): static
    {
        $translations = $this->package()->novaTranslations();

        if (Normalizer::not($translations)) {
            return $this;
        }

        $dependency = Dependency::use('Laravel\Nova\Nova', 'laravel/nova', 'nova translations');

        $dependency->get('translations', Translations::json($this));

        return $this;
    }
}
