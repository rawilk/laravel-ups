---
title: Void Shipments
sort: 4
---

## Introduction

With the void shipments api, you are able to void your created shipments. You will just need the shipment identification number
to void a shipment.

## Usage

The most basic usage involves voiding an entire shipment.

```php
$response = (new VoidShipment)
    ->usingShipmentIdentificationNumber('YOUR TRACKING NUMBER')
    ->void();

$response->status->successful(); // true
$response->failed(); // false
```

## Partial Voids

If you have multiple packages in a shipment, you can void only some of them using a partial void.

```php
$response = (new VoidShipment)
    ->usingShipmentIdentificationNumber('YOUR TRACKING NUMBER')
    ->usingTrackingNumbers(['PACKAGE TRACKING NUMBER'])
    ->void();

$response->status->successful(); // true
$response->status->partiallyVoided(); // true

// If there are packages remaining in the shipment, a collection of PackageLevelResult entities will be returned.
$response->package_level_results->first()->voided(); // true
$response->package_level_results[1]->voided(); // false
```

If you void all the packages in a shipment, the entire shipment will be considered voided and
`$response->package_level_results` will be `null`.

## Handling Errors

A lot can go wrong when voiding a package or shipment. The most common scenario is you waited too long to void a shipment,
or you tried to void a shipment after it has already been picked up. You only have **28** days to void a shipment through
the api.

You can handle errors by using the following methods and properties on the void response object:

```php
$response->failed();
$response->error_description;
$response->error_code;
```
