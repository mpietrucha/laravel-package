<?php

namespace Mpietrucha\Laravel\Package\Translations;

use Mpietrucha\Utility\Filesystem\Path;

/**
 * @phpstan-type Package string
 * @phpstan-type App string
 * @phpstan-type Publishable array<Package, App>
 *
 * @extends \Mpietrucha\Laravel\Package\Translations\Transformer<Package, App>
 */
class Builder extends Transformer
{
    /**
     * @return Publishable
     */
    public function __invoke(string $package): array
    {
        $app = Path::join('vendor', $this->tag()) |> $this->app()->langPath(...);

        return [$package => $app];
    }
}
