<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Credentials
    |--------------------------------------------------------------------------
    |
    | Here are the credentials needed when making requests through the
    | the UPS api.
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

    /*
    |--------------------------------------------------------------------------
    | Label Storage Disk
    |--------------------------------------------------------------------------
    |
    | Enter the disk name to use for storing generated shipping labels.
    |
    */
    'label_storage_disk' => env('UPS_LABEL_DISK', 'default'),

    /*
    |--------------------------------------------------------------------------
    | Rotate Stored Labels
    |--------------------------------------------------------------------------
    |
    | Set to true to automatically rotate stored shipping labels to be
    | stored vertically. Requires the Imagick extension.
    |
    */
    'rotate_stored_labels' => true,
];
