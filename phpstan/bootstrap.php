<?php

use Mpietrucha\PHPStan\Actions\IdeHelpers;
use Mpietrucha\PHPStan\Actions\Laravel;
use Mpietrucha\PHPStan\Actions\MixinAnalyzers;

Laravel::run();

IdeHelpers::run();
MixinAnalyzers::run();
