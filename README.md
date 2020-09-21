# laravel-ups

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rawilk/laravel-ups.svg?style=flat-square)](https://packagist.org/packages/rawilk/laravel-ups)
![Tests](https://github.com/rawilk/laravel-ups/workflows/Tests/badge.svg?style=flat-square)
[![Total Downloads](https://img.shields.io/packagist/dt/rawilk/laravel-ups.svg?style=flat-square)](https://packagist.org/packages/rawilk/laravel-ups)

**Note:** Replace ```Randall Wilk``` ```rawilk``` ```randall@randallwilk.dev``` ```laravel-ups``` ```UPS api wrapper for Laravel.``` with their correct values in [README.md](README.md), [CHANGELOG.md](CHANGELOG.md), [CONTRIBUTING.md](CONTRIBUTING.md), [LICENSE.md](LICENSE.md) and [composer.json](composer.json) files, then delete this line. You can also run `configure-laravel-ups.sh` to do this automatically.

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require rawilk/laravel-ups
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Rawilk\LaravelUps\LaravelUpsServiceProvider" --tag="migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Rawilk\LaravelUps\LaravelUpsServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

``` php
$laravel-ups = new Rawilk\LaravelUps;
echo $laravel-ups->echoPhrase('Hello, Rawilk!');
```

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security

Please review [my security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

- [Randall Wilk](https://github.com/rawilk)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
