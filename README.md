# UPS Wrapper for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rawilk/laravel-ups.svg?style=flat-square)](https://packagist.org/packages/rawilk/laravel-ups)
![Tests](https://github.com/rawilk/laravel-ups/workflows/Tests/badge.svg?style=flat-square)
[![Total Downloads](https://img.shields.io/packagist/dt/rawilk/laravel-ups.svg?style=flat-square)](https://packagist.org/packages/rawilk/laravel-ups)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/rawilk/laravel-ups?style=flat-square)](https://packagist.org/packages/rawilk/laravel-ups)
[![License](https://img.shields.io/github/license/rawilk/laravel-ups?style=flat-square)](https://github.com/rawilk/laravel-ups/blob/main/LICENSE.md)

![social image](https://banners.beyondco.de/UPS%20API%20Wrapper.png?theme=light&packageManager=composer+require&packageName=rawilk%2Flaravel-ups&pattern=architect&style=style_1&description=UPS+api+wrapper+for+Laravel.&md=1&showWatermark=0&fontSize=100px&images=truck)

This package acts as an api wrapper for the [UPS Api](https://www.ups.com/upsdeveloperkit?loc=en_US). Currently, this package allows you to validate addresses,
create shipments, void shipments, recover labels, and track shipments. Before using this package, you should have at least a basic understanding
of the UPS Api.

## Installation

You can install the package via composer:

```bash
composer require rawilk/laravel-ups
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="ups-config"
```

You can view the default config file here: https://github.com/rawilk/laravel-ups/blob/main/config/ups.php

## Documentation

For documentation, please visit: https://randallwilk.dev/docs/laravel-ups.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security

Please review [my security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

-   [Randall Wilk](https://github.com/rawilk)
-   [All Contributors](../../contributors)

## Disclaimer

This package is not affiliated with, maintained, authorized, endorsed or sponsored by Laravel or any of its affiliates. It is also not affiliated with, maintained, authorized, endorsed or sponsored by UPS.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
