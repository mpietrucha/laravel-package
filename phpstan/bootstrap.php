<?php

use Mpietrucha\PHPStan\IdeHelpers;
use Mpietrucha\PHPStan\Laravel;
use Mpietrucha\PHPStan\MixinAnalyzers;

Laravel::run();

IdeHelpers::run();
MixinAnalyzers::run();
