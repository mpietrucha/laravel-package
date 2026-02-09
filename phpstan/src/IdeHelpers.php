<?php

namespace Mpietrucha\PHPStan;

use Illuminate\Support\Facades\Artisan;
use Mpietrucha\PHPStan\Bootstrap\Action;
use Mpietrucha\PHPStan\Bootstrap\Cache;
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

        if (Cache::validate('composer', $composer)) {
            return true;
        }

        $facades = storage_path('app/framework/cache') |> Filesystem::snapshot(...);

        if (Type::null($facades)) {
            return false;
        }

        return Cache::validate('facades', $facades);
    }

    protected static function handle(): void
    {
        Artisan::call('ide:helpers');
    }
}
