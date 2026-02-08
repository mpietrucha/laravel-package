<?php

namespace Mpietrucha\Laravel\Essentials\Commands\Concerns;

use Mpietrucha\Utility\Collection;
use Mpietrucha\Utility\Process;

trait InteractsWithLint
{
    /**
     * @param  string|list<string>  $files
     */
    protected function lint(iterable|string $files): void
    {
        /** @var \Mpietrucha\Utility\Collection<int, string> $files */
        $files = Collection::wrap($files);

        Process::run(['composer', 'lint', ...$files]);
    }
}
