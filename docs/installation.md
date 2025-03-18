---
title: Installation & Setup
sort: 4
---

## Installation

laravel-ups can be installed via composer:

```bash
composer require rawilk/laravel-ups
```

## Configuration

### Publishing the config file

You may publish the config file like this:

```bash
php artisan vendor:publish --tag="ups-config"
```

See the default configuration values [here](https://github.com/rawilk/laravel-ups/blob/{branch}/config/ups.php).

### Configuring the package

You will need to provide your UPS account credentials for this package to work. You can either enter your credentials in your `.env`
file, or directly in the config file (not recommended).

At a minimum, you will need:

- Account Access Key (`UPS_ACCESS_KEY`): Your account needs an api access key, which can be obtained here: [https://www.ups.com/upsdeveloperkit/manageaccesskeys?loc=en_US](https://www.ups.com/upsdeveloperkit/manageaccesskeys?loc=en_US)
- User ID (`UPS_USER_ID`): The username you use to login to your UPS account.
- Password (`UPS_PASSWORD`): The password you use to login to your UPS account.
- Shipper Number (`UPS_SHIPPER_NUMBER`): This is a 6 digit number assigned to you by UPS.

If your account has negotiated rates enabled for it, you can set `UPS_NEGOTIATED_RATES` to `true`.

To store generated shipping labels on a custom storage disk, you can specify the disk name in the `UPS_LABEL_DISK` .env key.
