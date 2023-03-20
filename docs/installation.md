---
title: Installation & Setup
sort: 3
---

## Installation

laravel-ups can be installed via composer:

```bash
composer require rawilk/laravel-ups:1.0
```

## Configuration

### Publishing the config file

You may publish the config file like this:

```bash
php artisan vendor:publish --provider="Rawilk\Ups\UpsServiceProvider" --tag="config"
```

This is the default content of `config/ups.php`:

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

### Configuring the package

You will need to provide your UPS account credentials for this package to work. You can either enter your credentials in your `.env`
file, or directly in the config file (not recommended).

At a minimum, you will need:

- Account Access Key (`UPS_ACCESS_KEY`): Your account needs an api access key, which can be obtained here: https://www.ups.com/upsdeveloperkit/manageaccesskeys?loc=en_US
- User ID (`UPS_USER_ID`): The username you use to login to your UPS account.
- Password (`UPS_PASSWORD`): The password you use to login to your UPS account.
- Shipper Number (`UPS_SHIPPER_NUMBER`): This is a 6 digit number assigned to you by UPS.

If your account has negotiated rates enabled for it, you can set `UPS_NEGOTIATED_RATES` to `true`.
