---
title: Tracking
sort: 3
---

## Introduction

Like the name suggests, the tracking api allows you to track your shipments via the api.

## Usage

The most basic usage of the api involves providing a tracking number for a package or shipment. Please consult the
[developer documentation](https://www.ups.com/upsdeveloperkit?loc=en_US) before using.

```php
use Rawilk\Ups\Apis\Tracking\Tracking;

$response = (new Tracking)
    ->usingTrackingNumber('YOUR TRACKING NUMBER')
    ->track();

// On a successful request, the "shipment" attribute will return an instance of Rawilk/Ups/Entity/Shipment/Shipment.
$response->shipment;
```

When using a `Shipment` instance created from the package's tracking response, there are a few pieces of information you
can retrieve from it:

```php
// Returns a Carbon date instance of the date the shipment was picked up
// returns null if not picked up yet
$response->shipment->pickup_date;

// Returns true if the shipment has been picked up
$response->shipment->isPickedUp();

// Returns an instance of Rawilk/Ups/Entity/Shipment/ReferenceNumber if there is a reference number on the shipment.
// May return an array of instances if more than one reference number is found.
$response->shipment->reference_number;
$response->shipment->reference_number->code;

// Returns a collection of Rawilk/Ups/Entity/Shipment/Package instances.
$response->shipment->packages;

// Get the first package in the shipment...
$package = $response->shipment->packages->first();

// Returns a collection of tracking activities for the package (Rawilk/Ups/Entity/Activity/Activity)
$package->activities;

// Returns true if the package has an activity with a "delivery" code on it.
$package->isDelivered();

// If the package has an activity that was "delivered" and there as a signature, it will return
// the name of the person that signed.
$package->signedForByName();

// If the package has any activities that have a "pickup" code, this will return true.
// Note: Depending on your request options, you may not see any activities marked as "pickup".
$package->isPickedUp();
```

## Activity

For each package, there can be multiple activities recorded by UPS. Each of them are converted to an `Rawilk/Ups/Entity/Activity/Activity` instance
when a response is read from the api. Here is some of the information you can get from an activity.

```php
// Returns a Carbon instance of the parsed date/time of the activity.
$activity->date_time;

// Some other date/times available
$activity->date;
$activity->time;
$activity->gmt_date;
$activity->gmt_time;
$activity->gmt_offset;

// Package activity status container. Useful in determining what kind of activity it is.
$activity->status;

// Will return a code of the status of the activity.
// 'D' => Delivered
// 'P' => Pickup
$activity->status->status_type->code;

// Name of person who signed for package.
$activity->signed_for_by_name;

// Convenience method for determining if it is a "pickup" activity.
$activity->isPickup();

// Convenience method for determining if it is a "delivered" activity.
$activity->isDelivered();
```

## Options

### Reference Number

UPS gives you the ability to track a package or shipment by using a reference number. Reference numbers can be a purchase order number,
job number, etc. Reference Number is supplied when generating a shipment.

```php
(new Tracking)->usingReferenceNumber('Your reference number');
```

### Shipper Number

Using your shipper number allows you to further limit the results to your account:

```php
(new Tracking)->usingShipperNumber('Your shipper number');
```

### Request Option

Allows for optional processing. Default is to include "All activity". Here are a couple ways you can specify the request option:

```php
$api = new Tracking;

// Via the "requestOption" method:
$api->requestOption(TrackingOptions::LAST_ACTIVITY);

// Via a convenience method:
$api->allActivity(); // TrackingOptions::ALL_ACTIVITY
$api->lastActivity(); // TrackingOptions::LAST_ACTIVITY
```

> {tip} There are more options available, found in `Rawilk/Ups/Apis/Tracking/TrackingOptions`. We've just added convenience methods
> for our common use cases.

## Error Handling

The most common errors you'll probably run into are for no tracking information available or invalid tracking numbers:

### No Tracking Information Available

When a shipment is created, its tracking information will not be available right away. It's best to wait at least 10 minutes before attempting
to retrieve any tracking information on it.

Here's how you can check for this error specifically:

```php
$response = (new Tracking)
    ->usingTrackingNumber('YOUR TRACKING NUMBER')
    ->track();

if ($response->noTrackingInformationAvailable()) {
    // do something
    echo $response->error_description;
}
```

### Invalid Tracking Number

When an invalid tracking number is used, ups will return an error. Here's how you can check for it:

```php
$response = (new Tracking)
    ->usingTrackingNumber('YOUR TRACKING NUMBER')
    ->track();

if ($response->invalidTrackingNumber()) {
    // do something
    echo $response->error_description;
}
```

### Other Errors

You can check for other errors by using `$response->failed()`:

```php
$response = (new Tracking)
    ->usingTrackingNumber('YOUR TRACKING NUMBER')
    ->track();

if ($response->failed()) {
    // do something
    echo $response->error_code; // E.g. 151018 for invalid tracking number
    echo $response->error_description;
}
```
