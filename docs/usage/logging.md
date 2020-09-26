---
title: Logging
sort: 2
---

## Logging

This package can optionally make use of the [logging provided by Laravel](https://laravel.com/docs/8.x/logging)
to log the contents of the requests and responses to and from the UPS api. This can be useful for debugging
your requests.

Logging is disabled by default, but can easily be enabled by adding `UPS_LOGGING=true` to your `.env` file,
or by setting the config value to true directly in the `config/ups.php` file.
