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

**Note:** All entities, like `Shipment` can be found in `Rawilk/Ups/Entity`.

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

{.tip}
> **Note:** For return shipments, **only one package is allowed per shipment**, so you will need to create multiple return shipments for more than one package.

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

## Options

For the `ShipConfirm` api phase, you can either validate the addresses, or skip the address validation. We have it defaulted to not validate
since we usually are validating any addresses before we create a shipment in our own workflows. You can change this behavior by doing this:

```php
// With validation
(new ShipConfirm)->withAddressValidation();

// Without address validation
(new ShipConfirm)->withoutAddressValidation();
```
