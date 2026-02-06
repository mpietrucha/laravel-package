# Laravel Essentials

An elegant abstraction layer for adding macros and mixins to Laravel and third-party classes. Built on top of Laravel's macroable system, it provides trait-based mixins, improved error context, and PHPStan integration for full static analysis support of dynamically registered methods.

## Requirements

- PHP 8.5+
- Laravel 12+

## Installation

```bash
composer require mpietrucha/laravel-essentials
```

## Usage

### Macros

The `Macro` class registers individual methods on any macroable class:

```php
use Mpietrucha\Laravel\Essentials\Macro;
use Illuminate\Support\Collection;

Macro::use(Collection::class, 'toUpper', function () {
    return $this->map(fn (string $item) => strtoupper($item));
});

collect(['hello', 'world'])->toUpper(); // ['HELLO', 'WORLD']
```

The registered macro has full access to `$this` and `static`, just like a native method on the destination class.

### Mixins

The `Mixin` class registers all public methods from a trait as macros on the destination class:

```php
use Mpietrucha\Laravel\Essentials\Mixin;
use Illuminate\Support\Collection;
use App\Mixins\CollectionMixin;

Mixin::use(Collection::class, CollectionMixin::class);
```

Define your mixin as a trait:

```php
trait CollectionMixin
{
    public function toUpper(): static
    {
        return $this->map(fn (string $item) => strtoupper($item));
    }

    public function toLower(): static
    {
        return $this->map(fn (string $item) => strtolower($item));
    }
}
```

Every public method in the trait becomes available on the destination class:

```php
collect(['Hello', 'World'])->toUpper(); // ['HELLO', 'WORLD']
collect(['Hello', 'World'])->toLower(); // ['hello', 'world']
```

You can also pass an object instance instead of a trait:

```php
use Illuminate\Support\Collection;
use App\Mixins\CollectionMixin;

Mixin::use(Collection::class, new CollectionMixin);
```

### Registering in a Service Provider

The recommended place to register macros and mixins is in a service provider's `boot` method:

```php
namespace App\Providers;

use App\Mixins\CollectionMixin;
use App\Mixins\RequestMixin;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Mpietrucha\Laravel\Essentials\Mixin;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Mixin::use(Collection::class, CollectionMixin::class);
        Mixin::use(Request::class, RequestMixin::class);
    }
}
```

### Compatibility

Macros and mixins work with any class that uses a macroable trait. The following implementations are supported out of the box:

- `Illuminate\Support\Traits\Macroable` (Laravel)
- `Spatie\Macroable\Macroable` (Spatie)
- `Filament\Support\Concerns\Macroable` (Filament)

You can register additional macroable implementations:

```php
use Mpietrucha\Laravel\Essentials\Macro\Implementation;

Implementation::use(CustomMacroable::class);
```

## PHPStan Integration

The package provides full PHPStan support for dynamically registered macros and mixins. This means your IDE and static analysis tools can understand methods added at runtime.

### Setup

Add the extension to your `phpstan.neon`:

```neon
includes:
    - vendor/mpietrucha/laravel-essentials/extension.neon
```

### Analyzer Generation

Analyzer files for registered mixins are generated automatically during PHPStan analysis. No manual step is required.

## Package Development

Laravel Essentials provides a base service provider and builder for developing Laravel packages.

### Service Provider

Extend the provided `ServiceProvider` for a streamlined package setup built on [Spatie's Laravel Package Tools](https://github.com/spatie/laravel-package-tools):

```php
use Mpietrucha\Laravel\Essentials\Package\Builder;
use Mpietrucha\Laravel\Essentials\Package\ServiceProvider;

class MyPackageServiceProvider extends ServiceProvider
{
    public function configure(Builder $package): void
    {
        $package->name('my-package');
        $package->hasConsoleCommand(MyCommand::class);
    }
}
```

### Translations

The `InteractsWithTranslations` trait provides a convenient `__()` method that automatically scopes translation keys to your package:

```php
use Mpietrucha\Laravel\Essentials\Package\Translations\Concerns\InteractsWithTranslations;

class MyNotification
{
    use InteractsWithTranslations;

    public function message(): string
    {
        return static::__('notifications.welcome', ['name' => 'John']);
        // Resolves: my-package::notifications.welcome
    }
}
```

## License

Laravel Essentials is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
