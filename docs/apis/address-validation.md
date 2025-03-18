---
title: Address Validation
sort: 1
---

## Introduction

The Address Validation (Street Level) allows you to validate an address at street level. Suggestions are given when
an address is invalid.

> {note} Currently, only US & Puerto Rico are supported.

## Usage

```php
<?php

use Rawilk\Ups\Entity\Address\Address;
use Rawilk\Ups\Apis\AddressValidation\AddressValidation;

$address = new Address([
    'address_line1' => 'AIRWAY ROAD SUITE 7',
    'city' => 'San Diego',
    'state' => 'CA',
    'postal_code' => '92154',
    'country_code' => 'US',
]);

$response = (new AddressValidation)
    ->usingAddress($address)
    ->validate();

$response->ambiguous; // true
$response->candidates; // \Illuminate\Support\Collection of \Rawilk\Ups\Entity\AddressValidation\AddressValidationAddress instances.
```

The address shown in this example is from the developer documentation and should always return as ambiguous with some candidate options.

Here are some other ways you can interact with the returned response:

```php
// Indicates if the api was unable to offer any alternatives. Usually caused by a poorly formed address.
$response->no_candidates;

// Indicates if the api determined the given address was valid.
$response->valid;

// Returns true the api found multiple candidates and the address provided was not clear, but enough to find candidates.
$response->ambiguous;

// If any alternative addresses are found, they can be looped through this property. Candidates may
// still be returned even if the address was deemed "valid" by UPS.
$response->candidates;
```

## Options

There are a few options you can pass to the api when validation an address:

### Max Suggestions

You can limit the number of suggestions returned from the api. Must be an integer between `1` and `50`.

```php
$response = (new AddressValidation)
    ->usingAddress($address)
    ->maxSuggestions(3)
    ->validate();
```

### Request Option

There are three request options available:

- Address Validation (default)
- Address Classification
- Address Validation and Classification

There are a couple ways to set the request option:

```php
$api = new AddressValdiation;

// Using the `usingRequestOption` function
$api->usingRequestOption(AddressValidationOption::ADDRESS_VALIDATION);

// Using one of the convenience setter methods
$api->validationOnly();
$api->classificationOnly();
$api->classificationAndValidation();
```

For more information on these options, see [the documentation](https://www.ups.com/upsdeveloperkit?loc=en_US).
