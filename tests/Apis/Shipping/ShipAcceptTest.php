<?php

declare(strict_types=1);

use Rawilk\Ups\Apis\Shipping\ShipAccept;
use Rawilk\Ups\Apis\Shipping\ShipConfirm;
use Rawilk\Ups\Entity\Address\Address;
use Rawilk\Ups\Entity\Payment\BillShipper;
use Rawilk\Ups\Entity\Payment\PaymentInformation;
use Rawilk\Ups\Entity\Payment\Prepaid;
use Rawilk\Ups\Entity\Payment\RateInformation;
use Rawilk\Ups\Entity\Shipment\Label\LabelSpecification;
use Rawilk\Ups\Entity\Shipment\Package;
use Rawilk\Ups\Entity\Shipment\PackageResult;
use Rawilk\Ups\Entity\Shipment\PackageWeight;
use Rawilk\Ups\Entity\Shipment\PackagingType;
use Rawilk\Ups\Entity\Shipment\ReferenceNumber;
use Rawilk\Ups\Entity\Shipment\ShipFrom;
use Rawilk\Ups\Entity\Shipment\Shipment;
use Rawilk\Ups\Entity\Shipment\Shipper;
use Rawilk\Ups\Entity\Shipment\ShipTo;
use Rawilk\Ups\Exceptions\BadRequest;
use Rawilk\Ups\Responses\Shipping\ShipConfirmResponse;

it('can make api calls', function () {
    $shipConfirm = shipConfirmResponse();

    $response = (new ShipAccept)
        ->usingShipmentDigest($shipConfirm->shipment_digest)
        ->createShipment();

    expect($response->shipment_identification_number)->not()->toBeEmpty()
        ->and($response->packages)->toHaveCount(1);

    $this->assertContainsOnlyInstancesOf(PackageResult::class, $response->packages);
});

it('requires a shipment digest', function () {
    (new ShipAccept)->createShipment();
})->expectException(BadRequest::class);

// Helpers
function shipConfirmResponse(): ShipConfirmResponse
{
    $account = config('ups.shipper_number');

    $shipment = new Shipment([
        'shipper' => new Shipper([
            'shipper_number' => $account,
            'name' => 'Shipper Name',
            'address' => new Address([
                'address_line1' => '1401 E Main St',
                'city' => 'Merrill',
                'state' => 'WI',
                'postal_code' => '54452',
                'country_code' => 'US',
            ]),
        ]),

        'ship_to' => new ShipTo([
            'company_name' => 'Ship To Company Name',
            'attention_name' => 'Ship To Attn Name',
            'address' => new Address([
                'address_line1' => '5017 N 28th Ave',
                'city' => 'Wausau',
                'state' => 'WI',
                'postal_code' => '54401',
                'country_code' => 'US',
                'residential' => true,
            ]),
        ]),

        'ship_from' => new ShipFrom([
            'company_name' => 'Ship From Company Name',
            'attention_name' => 'Ship From Attn Name',
            'address' => new Address([
                'address_line1' => '1401 E Main St',
                'city' => 'Merrill',
                'state' => 'WI',
                'postal_code' => '54452',
                'country_code' => 'US',
            ]),
        ]),

        'description' => 'Shipment description',

        'payment_information' => new PaymentInformation([
            'prepaid' => new Prepaid([
                'bill_shipper' => new BillShipper([
                    'account_number' => $account,
                ]),
            ]),
        ]),

        'packages' => [
            new Package([
                'packaging_type' => new PackagingType, // Customer supplied package
                'description' => 'Package description',
                'reference_number' => new ReferenceNumber([
                    'value' => 'Package',
                ]),
                'package_weight' => new PackageWeight([
                    'weight' => '60.0',
                ]),
                'is_large_package' => true,
            ]),
        ],
    ]);

    if (config('ups.negotiated_rates')) {
        $shipment->rate_information = new RateInformation([
            'negotiated_rates' => true,
        ]);
    }

    return (new ShipConfirm)
        ->withShipment($shipment)
        ->withLabelSpecification(LabelSpecification::asGIF())
        ->getDigest();
}
