<?php

namespace Mpietrucha\Laravel\Package\Translations;

use Mpietrucha\Utility\Filesystem\Path;

/**
 * @phpstan-import-type Package from \Mpietrucha\Laravel\Package\Translations\Builder
 *
 * @extends \Mpietrucha\Laravel\Package\Translations\Transformer<int, Package>
 */
class Vendor extends Transformer
{
    public function __invoke(string $vendor): string
    {
        $app = $this->app()->basePath();

        return Path::join($app, 'vendor', $vendor) |> static::hydrate(...);
    }
}
