<?php

declare(strict_types=1);

use Carbon\Carbon;
use Rawilk\Ups\Apis\Tracking\Tracking;
use Rawilk\Ups\Apis\Tracking\TrackingTestNumbers;
use Rawilk\Ups\Entity\Activity\Activity;
use Rawilk\Ups\Entity\Shipment\Package;
use Rawilk\Ups\Entity\Shipment\ReferenceNumber;
use Rawilk\Ups\Entity\Shipment\Shipment;

it('can make api calls', function () {
    $response = (new Tracking)
        ->usingTrackingNumber(TrackingTestNumbers::ALL_2ND_DAY_AIR_DELIVERED)
        ->track();

    expect($response->shipment)->toBeInstanceOf(Shipment::class)
        ->and($response->shipment->packages)->toHaveCount(1)
        ->and($response->shipment->pickup_date)->toBeInstanceOf(Carbon::class)
        ->and($response->shipment->isPickedUp())->toBeTrue()
        ->and($response->shipment->reference_number)->toBeInstanceOf(ReferenceNumber::class)
        ->and($response->shipment->reference_number->code)->toBe('01');

    $this->assertContainsOnlyInstancesOf(Package::class, $response->shipment->packages);

    /** @var \Rawilk\Ups\Entity\Shipment\Package $firstPackage */
    $firstPackage = $response->shipment->packages->first();

    expect($firstPackage->isDelivered())->toBeTrue()
        ->and($firstPackage->signedForByName())->toBe('HELEN SMITH');
});

it('can determine if delivered from last activity only', function () {
    $response = (new Tracking)
        ->usingTrackingNumber(TrackingTestNumbers::LAST_WORLD_WIDE_EXPRESS_DELIVERED)
        ->lastActivity()
        ->track();

    /** @var \Rawilk\Ups\Entity\Shipment\Package $package */
    $package = $response->shipment->packages->first();

    expect($package->activities)->count()->toBe(1)
        ->and($package->isDelivered())->toBeTrue()
        ->and($package->signedForByName())->toBe('DAVID ADAMS');

    $this->assertContainsOnlyInstancesOf(Activity::class, $package->activities);
});

it('can get tracking info for multiple packages in a shipment', function () {
    $response = (new Tracking)
        ->usingTrackingNumber(TrackingTestNumbers::$deliveredShipmentWithMultiplePackages['shipment_identification_number'])
        ->track();

    expect($response->shipment->shipment_identification_number)->toBe(TrackingTestNumbers::$deliveredShipmentWithMultiplePackages['shipment_identification_number'])
        ->and($response->shipment->packages)->toHaveCount(2)
        ->and($response->shipment->isPickedUp())->toBeTrue();

    /** @var \Rawilk\Ups\Entity\Shipment\Package $firstPackage */
    $firstPackage = $response->shipment->packages->first();

    expect($firstPackage->tracking_number)->toBe(TrackingTestNumbers::$deliveredShipmentWithMultiplePackages['shipment_identification_number'])
        ->and($firstPackage->isDelivered())->toBeTrue();

    /** @var Package $secondPackage */
    $secondPackage = $response->shipment->packages[1];

    expect($secondPackage->tracking_number)->toBe(TrackingTestNumbers::$deliveredShipmentWithMultiplePackages['second_package'])
        ->and($secondPackage->isDelivered())->toBeTrue();
});

it('can determine if no tracking information is available', function () {
    $response = (new Tracking)
        ->usingTrackingNumber(TrackingTestNumbers::NO_TRACKING_INFORMATION_AVAILABLE)
        ->track();

    expect($response->failed())->toBeTrue()
        ->and($response->error_code)->toBe('151044')
        ->and($response->noTrackingInformationAvailable())->toBeTrue()
        ->and($response->invalidTrackingNumber())->toBeFalse();
});

it('can determine if a tracking number is invalid', function () {
    $response = (new Tracking)
        ->usingTrackingNumber(TrackingTestNumbers::INVALID_TRACKING_NUMBER)
        ->track();

    expect($response->failed())->toBeTrue()
        ->and($response->error_code)->toBe('151018')
        ->and($response->noTrackingInformationAvailable())->toBeFalse()
        ->and($response->invalidTrackingNumber())->toBeTrue();
});

it('can be delivered with no signature', function () {
    $response = (new Tracking)
        ->usingTrackingNumber(TrackingTestNumbers::DELIVERED_NO_SIGNATURE)
        ->track();

    expect($response->shipment->isPickedUp())->toBeTrue();

    /** @var \Rawilk\Ups\Entity\Shipment\Package $package */
    $package = $response->shipment->packages->first();

    expect($package->isDelivered())->toBeTrue()
        ->and($package->signedForByName())->toBeNull();
});
