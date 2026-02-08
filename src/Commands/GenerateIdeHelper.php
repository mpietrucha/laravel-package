<?php

namespace Mpietrucha\Laravel\Essentials\Commands;

use Illuminate\Console\Command;
use Mpietrucha\Laravel\Essentials\Commands\Concerns\InteractsWithLint;

class GenerateIdeHelper extends Command
{
    use InteractsWithLint;

    /**
     * @var string
     */
    protected $signature = 'ide:helper';

    /**
     * @var string
     */
    protected $description = 'Generate IDE helper files';

    public function handle(): void
    {
        $this->callSilently('ide-helper:generate');
        $this->callSilently('ide-helper:models --write-mixin');

        app_path('Models') |> $this->lint(...);

        $this->info('IDE helper files generated successfully.');
    }
}
