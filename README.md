# laravel-ups

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rawilk/laravel-ups.svg?style=flat-square)](https://packagist.org/packages/rawilk/laravel-ups)
![Tests](https://github.com/rawilk/laravel-ups/workflows/Tests/badge.svg?style=flat-square)
[![Total Downloads](https://img.shields.io/packagist/dt/rawilk/laravel-ups.svg?style=flat-square)](https://packagist.org/packages/rawilk/laravel-ups)

This package acts as an api wrapper for the [UPS Api](https://www.ups.com/upsdeveloperkit?loc=en_US). Currently this package allows you to validate addresses,
create shipments, void shipments, recover labels, and track shipments. Before using this package, you should have at least a basic understanding
of the UPS Api.

## Installation

You can install the package via composer:

```bash
composer require rawilk/laravel-ups
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Rawilk\Ups\UpsServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [
    /*
    |--------------------------------------------------------------------------
    | Credentials
    |--------------------------------------------------------------------------
    |
    | Here are the credentials needed when making requests through the
    } the UPS api.
    |
    */
    'access_key' => env('UPS_ACCESS_KEY'),
    'user_id' => env('UPS_USER_ID'),
    'password' => env('UPS_PASSWORD'),
    'shipper_number' => env('UPS_SHIPPER_NUMBER'),
    'negotiated_rates' => env('UPS_NEGOTIATED_RATES', false),

    /*
    |--------------------------------------------------------------------------
    | Sandbox
    |--------------------------------------------------------------------------
    |
    | Enabling "sandbox" mode instructs the package to send any api requests
    | to the customer integrated environment (testing environment) instead
    | of the production api, with the exception of the address validation
    | api.
    |
    */
    'sandbox' => env('UPS_SANDBOX', true),

    /*
    |--------------------------------------------------------------------------
    | Logging
    |--------------------------------------------------------------------------
    |
    | Enable/Disable logging when requests are made and received
    | through the UPS api.
    |
    */
    'logging' => env('UPS_LOGGING', false),
];
```

## Documentation

For documentation, please visit: https://randallwilk.dev/docs/laravel-ups.

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
