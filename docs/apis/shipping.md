---
title: Shipping
sort: 2
---

## Introduction

The Shipping Api allows you to register shipments, including return shipments.

The shipping flow consists of two steps:

- **Confirm:** Send information to UPS to get it validated and get a digest you can use to accept the shipment.
- **Accept:** Finalize the shipment, mark it as will be shipped. Get label and additional information.

## Usage

This is a basic example of how you can create a shipment through UPS. Your use case might demand more or less information to be sent to UPS.
Please consult [the developer documentation](https://www.ups.com/upsdeveloperkit?loc=en_US) to see what can all be sent.

> {tip} All entities, like `Shipment` can be found in `Rawilk/Ups/Entity`.

```php
// You can get this a different way if you have it stored somewhere else.
$shipperNumber = Config::get('ups.shipper_number');

$shipment = new Shipment([
    'shipper' => new Shipper([
        'shipper_number' => $shipperNumber,
        'name' => 'Your business name',
        'address' => new Address([
            'address_line1' => 'Your business address',
            //'address_line2' => '',
            'city' => 'San Diego',
            'state' => 'CA',
            'postal_code' => '12345',
            'country_code' => 'US',
        ]),
    ]),

    'ship_to' => new ShipTo([
        'company_name' => 'Ship To Company Name',
        'attention_name' => 'Ship To Attn Name',
        'address' => new Address([
            'address_line1' => 'Consignee address',
            'city' => 'San Diego',
            'state' => 'CA',
            'postal_code' => '12345',
            'country_code' => 'US',
        ]),
    ]),

    'ship_from' => new ShipFrom([
        'company_name' => 'Ship From Company Name',
        'attention_name' => 'Ship From Attn Name',
        'address' => new Address([
            'address_line1' => 'Your company address',
            'city' => 'San Diego',
            'state' => 'CA',
            'postal_code' => '12345',
            'country_code' => 'US',
        ]),
    ]),

    'description' => 'Shipment description',

    // Uncomment for return shipment
    // 'return_service' => new ReturnService, // defaults to ReturnService::PRINT_RETURN_LABEL for the 'code'

    // Payment info - for other options, see the developer docs
    'payment_information' => PaymentInformation::prepaidForAccount($shipperNumber),

    'packages' => [
        new Package([
            'packaging_type' => new PackagingType, // Default: Customer supplied package
            'description' => 'Package description', // Required for return shipments
            'reference_number' => new ReferenceNumber([
                'value' => 'My reference',
                // 'barcode' => true, // Uncomment to have outputted as barcode on bottom of label
            ]),
            'package_weight' => new PackageWeight([
                'weight' => '5.0', // UOM defaults to LBS
            ]),
            // 'is_large_package' => true,
        ]),
    ],
]);

// Note: By default, a "Service" entity is created on a shipment, using the "Ground" service option. You can
// change the service used by passing in your own "Service" entity on the "service" attribute.

// If you have negotiated rates enabled, you can specify you want to use it like this:
if (Config::get('ups.negotiated_rates')) {
    $shipment->rate_information = new RateInformation([
        'negotiated_rates' => true,
    ]);
}
```

> {note} For return shipments, **only one package is allowed per shipment**, so you will need to create multiple return shipments for more than one package.

Once you have your shipment entity created with all the necessary information, you need to generate a shipment digest with UPS.

```php
try {
    $response = (new ShipConfirm)
        ->withShipment($shipment)
        ->withLabelSpecification(LabelSpecification::asGIF()) // omit if you don't need the label
        ->getDigest();
} catch (\Rawilk\Ups\Exceptions\RequestFailed $e) {
    // Handle the exception
    dd($e);
}

// Get the new shipment's identification number
$response->shipment_identification_number;

// Get the shipment digest
$response->shipment_digest;
```

Once you have your shipment digest, you need to finalize the shipment:

```php
try {
    $response = (new ShipAccept)
        ->usingShipmentDigest($shipmentDigest)
        ->createShipment();
} catch (\Rawilk\Ups\Exceptions\RequestFailed $e) {
    // Handle the error.
}

// Get the new shipment's identification number
$response->shipment_identification_number;

// Returns a collection of packages returned from the api
// Wrapped in our \Rawilk\Ups\Entity\Shipment\PackageResult entity.
$response->packages;

// Each package has a tracking number
// The first package's tracking number should match the shipment identification number.
$response->packages->first()->tracking_number;
```

## Charges

Any charges from UPS will be available through the `ShipAcceptResponse::charges` attribute. You will receive a collection of
`Rawilk\Ups\Entity\Payment\Charge` instances.

```php
$charge = $response->charges->first();

$charge->monetary_value;

$charge->description;
```

## Billing Weight

The billing weight can be retrieved through the `ShipAcceptResponse::billing_weight` attribute.

```php
$weight = $reponse->billing_weight;

$weight->weight;
$weight->unit_of_measurement->code; // LBS
```

## Labels

A label is created for each package. You can retrieve the label's off each `PackageResult` entity instance.

```php
$image = $package->label_image;

// Base 64 encoded graphic image
$image->graphic_image;

// Base 64 encoded html browser image rendering software. This is only returned for GIF image formats.
$image->html_image;

// This is only returned if the label link is requested to be returned and only at the first package result.
$image->url;
```

### Label URLs

To receive a URL of the label, you can request it through shipment service options in the shipment confirmation phase.

```php
$shipment->shipment_service_options->label_delivery = new LabelDelivery([
    'label_links' => true,
]);
```

### Retrieving Decoded Labels

When a label is returned from UPS, it is base64 encoded. As of version `2.1.0`, the package can return the decoded
version of the image label for you off of each `PackageResult` entity.

```php
$image = $package->getDecodedImageContent();
```

If you want to decode it yourself, you can do it like this:

```php
$image = base64_decode($package->label_image->graphic_image);
```

### Storing Labels

If you would like, as of version `2.1.0`, you can have each `PackageResult` entity instance storage an image of the generated shipping
label automatically for you instead of having to `base64_decode` and store the image yourself. All that is required
providing a storage disk name in the configuration file (defaults to `default`), and then telling each package result
to store the image.

```php
$fileName = $package->storeLabel();
```

The `storeLabel` method will return the name of the file created on your configured disk, which defaults to: `TRACKING_NUMBER.png`

> {note} This will store the label as a .png file, regardless of the image format you requested from UPS.

I personally prefer to configure a storage disk for most items. Here's an example of a custom storage disk in `config/filesystems.php`:

```php
'disks' => [
    // ...
    'shipment-labels' => [
        'driver' => 'local',
        'root' => storage_path('app/shipment-labels'),
        'url' => env('APP_URL') . '/shipment-labels',
    ],
],

'links' => [
    // ...
    public_path('shipment-labels') => storage_path('app/shipment-labels'),
],
```

> {tip} Be sure to add your custom disk name to the `label_storage_disk` key in the package configuration.

### Rotating Stored Labels

I personally prefer to rotate stored shipping labels vertically. If you have the Imagick extension installed,
you can have the `PackageResult` entity do this automatically for you by setting the package configuration
key `rotate_stored_labels` to `true`.

## Options

For the `ShipConfirm` api phase, you can either validate the addresses, or skip the address validation. We have it defaulted to not validate
since we usually are validating any addresses before we create a shipment in our own workflows. You can change this behavior by doing this:

```php
// With validation
(new ShipConfirm)->withAddressValidation();

// Without address validation
(new ShipConfirm)->withoutAddressValidation();
```
