<?php

namespace Mpietrucha\PHPStan\Actions;

use Illuminate\Support\Facades\Artisan;
use Mpietrucha\Utility\Composer;
use Mpietrucha\Utility\Filesystem;
use Mpietrucha\Utility\Type;

/**
 * @internal
 */
abstract class IdeHelpers extends Action
{
    public static function due(): bool
    {
        $composer = Composer::get()->file() |> Filesystem::hash(...);

        if (Cache::stale('composer', $composer)) {
            return true;
        }

        $facades = storage_path('app/framework/cache') |> Filesystem::snapshot(...);

        if (Type::null($facades)) {
            return false;
        }

        return Cache::stale('facades', $facades);
    }

    protected static function handle(): void
    {
        Artisan::call('ide:helpers');
    }
}
