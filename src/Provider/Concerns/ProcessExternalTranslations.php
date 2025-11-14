<?php

namespace Mpietrucha\Laravel\Package\Provider\Concerns;

use Mpietrucha\Laravel\Package\Provider\Exception\ExternalTranslationsException;
use Mpietrucha\Utility\Filesystem;
use Mpietrucha\Utility\Filesystem\Path;
use Mpietrucha\Utility\Type;

/**
 * @phpstan-require-extends \Mpietrucha\Laravel\Package\ServiceProvider
 */
trait ProcessExternalTranslations
{
    protected function bootPackageExternalTranslations(): static
    {
        $translations = $this->buildPackageExternalTranslations();

        if (Type::null($translations)) {
            return $this;
        }

        $tag = $this->package()->tag();

        $this->publishes([
            $translations => $this->app->langPath("vendor/$tag"),
        ], "$tag-translations");

        return $this;
    }

    protected function buildPackageExternalTranslations(): ?string
    {
        $translations = $this->package()->externalTranslations();

        if (Type::null($translations)) {
            return null;
        }

        $translations = Path::build("../../$translations/resources/lang", $this->package()->basePath());

        if (Filesystem::is()->directory($translations)) {
            return $translations;
        }

        ExternalTranslationsException::for($translations)->throw();
    }
}
