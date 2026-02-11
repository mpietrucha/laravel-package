<?php

namespace Mpietrucha\Laravel\Essentials\Commands;

use Illuminate\Console\Command;
use Mpietrucha\Laravel\Essentials\Commands\Concerns\InteractsWithLint;
use Mpietrucha\Laravel\Essentials\Mixin;
use Mpietrucha\Laravel\Essentials\Mixin\Analyzer;
use Mpietrucha\Laravel\Essentials\Package\Context;
use Mpietrucha\Utility\Collection;
use Mpietrucha\Utility\Enumerable\Contracts\EnumerableInterface;
use Mpietrucha\Utility\Filesystem;
use Mpietrucha\Utility\Filesystem\Extension;
use Mpietrucha\Utility\Filesystem\Path;
use Mpietrucha\Utility\Type;

/**
 * @phpstan-import-type MixinCollection from \Mpietrucha\Laravel\Essentials\Mixin
 */
class GenerateMixinAnalyzers extends Command
{
    use InteractsWithLint;

    /**
     * @var string
     */
    protected $signature = 'mixin:analyzers';

    /**
     * @var string
     */
    protected $description = 'Generate PHPStan analyzer files for registered mixins
                              {--cwd= : The current working directory used for generating analyzers}
                              {--directory=phpstan/cache : The output directory for generated analyzer files}';

    public function handle(): void
    {
        $files = Mixin::map()->pipeThrough([
            fn (EnumerableInterface $map) => $this->build(...) |> $map->mapWithKeys(...),
            fn (EnumerableInterface $map) => $map->filter(),
            fn (EnumerableInterface $map) => Filesystem::put(...) |> $map->eachKeys(...),
            fn (EnumerableInterface $map) => $map->keys(),
        ]);

        if ($files->isEmpty()) {
            $this->info('No mixins found.');

            return;
        }

        $this->lint($files);

        $this->info('Mixin analyzers generated successfully.');

        $files->each(fn (string $file) => $this->components->task($file));
    }

    /**
     * @param  MixinCollection  $mixins
     * @param  class-string  $destination
     * @return null|array<string, string>
     */
    protected function build(Collection $mixins, string $destination): ?array
    {
        $content = Analyzer::content($destination, $mixins);

        if (Type::null($content)) {
            return null;
        }

        return [$this->file($destination) => $content];
    }

    protected function file(string $destination): string
    {
        $name = Path::name($destination);

        return Path::build(Extension::set($name, 'php'), $this->directory());
    }

    protected function directory(): string
    {
        /** @var string $directory */
        $directory = $this->option('directory');

        /** @var string $cwd */
        $cwd = $this->option('cwd') ?? Context::directory();

        return Path::build($directory, $cwd);
    }
}
