<?php

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
    'sandbox' => env('UPS_SANDBOX', true),
    'shipper_number' => env('UPS_SHIPPER_NUMBER'),
    'negotiated_rates' => env('UPS_NEGOTIATED_RATES', false),

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
