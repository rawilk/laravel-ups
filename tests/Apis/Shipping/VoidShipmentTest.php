<?php

declare(strict_types=1);

use Illuminate\Support\Collection;
use Rawilk\Ups\Apis\Shipping\Support\VoidTestNumbers;
use Rawilk\Ups\Apis\Shipping\VoidShipment;
use Rawilk\Ups\Entity\Shipment\PackageLevelResult;
use Rawilk\Ups\Exceptions\BadRequest;

it('can void shipments', function (string $shipmentIdentificationNumber) {
    $response = (new VoidShipment)
        ->usingShipmentIdentificationNumber($shipmentIdentificationNumber)
        ->void();

    expect($response->status->successful())->toBeTrue()
        ->and($response->failed())->toBeFalse();
})->with('validShipmentVoidNumbers');

it('can void the lead package', function () {
    $response = (new VoidShipment)
        ->usingShipmentIdentificationNumber(VoidTestNumbers::$partialVoidLeadPackage['shipment_id'])
        ->usingTrackingNumbers([VoidTestNumbers::$partialVoidLeadPackage['tracking_number']])
        ->void();

    expect($response->status->successful())->toBeTrue()
        ->and($response->package_level_results)->toBeInstanceOf(Collection::class)
        ->and($response->package_level_results)->toHaveCount(1)
        ->and($response->package_level_results->first()->voided())->toBeTrue();

    $this->assertContainsOnlyInstancesOf(PackageLevelResult::class, $response->package_level_results);
});

it('can void remaining package', function () {
    $response = (new VoidShipment)
        ->usingShipmentIdentificationNumber(
            VoidTestNumbers::$multiPackageShipmentVoidRemainingPackage['shipment_id']
        )
        ->usingTrackingNumbers(
            [VoidTestNumbers::$multiPackageShipmentVoidRemainingPackage['tracking_number']]
        )
        ->void();

    expect($response->status->successful())->toBeTrue()
        ->and($response->package_level_results)->toBeNull();
});

it('can void all remaining packages', function () {
    $response = (new VoidShipment)
        ->usingShipmentIdentificationNumber(
            VoidTestNumbers::$multiPackageWithTwoRemainingUnvoided['shipment_id']
        )
        ->usingTrackingNumbers(
            VoidTestNumbers::$multiPackageWithTwoRemainingUnvoided['tracking_numbers']
        )
        ->void();

    expect($response->status->successful())->toBeTrue()
        ->and($response->status->partiallyVoided())->toBeFalse()
        ->and($response->package_level_results)->toBeNull();
});

it('can void packages even if some of the sent packages cannot be voided', function () {
    $response = (new VoidShipment)
        ->usingShipmentIdentificationNumber(
            VoidTestNumbers::$multiPackageShipmentWithNonVoidablePackage['shipment_id']
        )
        ->usingTrackingNumbers(
            VoidTestNumbers::$multiPackageShipmentWithNonVoidablePackage['tracking_numbers']
        )
        ->void();

    expect($response->status->successful())->toBeTrue()
        ->and($response->status->partiallyVoided())->toBeTrue()
        ->and($response->package_level_results)->toHaveCount(2);

    /** @var \Rawilk\Ups\Entity\Shipment\PackageLevelResult $shouldBeVoided */
    $shouldBeVoided = $response->package_level_results
        ->firstWhere('tracking_number', VoidTestNumbers::$multiPackageShipmentWithNonVoidablePackage['tracking_numbers'][0]);

    expect($shouldBeVoided->voided())->toBeTrue();

    /** @var \Rawilk\Ups\Entity\Shipment\PackageLevelResult $shouldNotBeVoided */
    $shouldNotBeVoided = $response->package_level_results
        ->firstWhere('tracking_number', VoidTestNumbers::$multiPackageShipmentWithNonVoidablePackage['tracking_numbers'][1]);

    expect($shouldNotBeVoided->notVoided())->toBeTrue();
});

it('will not void expired shipments', function () {
    $response = (new VoidShipment)
        ->usingShipmentIdentificationNumber(
            VoidTestNumbers::GROUND_SINGLE_PACKAGE_SHIPMENT_VOIDING_EXPIRED
        )
        ->void();

    expect($response->failed())->toBeTrue()
        ->and($response->error_description)->not()->toBeEmpty()
        ->and($response->error_code)->toEqual('190101');
});

test('shipments already picked up will not be voided', function () {
    $response = (new VoidShipment)
        ->usingShipmentIdentificationNumber(
            VoidTestNumbers::SHIPMENT_ALREADY_PICKED_UP
        )
        ->void();

    expect($response->failed())->toBeTrue()
        ->and($response->error_description)->not()->toBeEmpty()
        ->and($response->error_code)->toEqual('190103');
});

test('shipments older than 28 days will not be voided', function () {
    $response = (new VoidShipment)
        ->usingShipmentIdentificationNumber(
            VoidTestNumbers::SHIPMENT_OLDER_THAN_28_DAYS
        )
        ->void();

    expect($response->failed())->toBeTrue()
        ->and($response->error_description)->not()->toBeEmpty()
        ->and($response->error_code)->toEqual('190101');
});

test('a package not in a shipment will not be voided', function () {
    $response = (new VoidShipment)
        ->usingShipmentIdentificationNumber(
            VoidTestNumbers::$trackingNumberNotInShipment['shipment_id']
        )
        ->usingTrackingNumbers(
            [VoidTestNumbers::$trackingNumberNotInShipment['tracking_number']]
        )
        ->void();

    expect($response->failed())->toBeTrue()
        ->and($response->error_description)->not()->toBeEmpty()
        ->and($response->error_code)->toEqual('190110');
});

test('return shipments cannot be voided at the package level', function () {
    $response = (new VoidShipment)
        ->usingShipmentIdentificationNumber(
            VoidTestNumbers::$returnShipmentFailAtPackageLevel['shipment_id']
        )
        ->usingTrackingNumbers(
            [VoidTestNumbers::$returnShipmentFailAtPackageLevel['tracking_number']]
        )
        ->void();

    expect($response->failed())->toBeTrue()
        ->and($response->error_description)->not()->toBeEmpty()
        ->and($response->error_code)->toEqual('190112');
});

it('requires a shipment identification number', function () {
    (new VoidShipment)->void();
})->expectException(BadRequest::class);

it('requires a valid shipment identification number', function (string $id) {
    (new VoidShipment)->usingShipmentIdentificationNumber($id)->void();
})->with('invalidShipmentNumbers')->expectException(BadRequest::class);

it('requires valid tracking numbers', function (string $id) {
    (new VoidShipment)
        ->usingShipmentIdentificationNumber(VoidTestNumbers::GROUND_SINGLE_PACKAGE_SHIPMENT_PROCESSED_AND_VOIDED)
        ->usingTrackingNumbers([$id])
        ->void();
})->with('invalidShipmentNumbers')->expectException(BadRequest::class);

dataset('validShipmentVoidNumbers', [
    VoidTestNumbers::GROUND_SINGLE_PACKAGE_SHIPMENT_PROCESSED_AND_VOIDED,
    VoidTestNumbers::SHIPMENT_VOIDED_AT_SHIPMENT_LEVEL,
    VoidTestNumbers::SHIPMENT_VOIDED_AT_SHIPMENT_LEVEL2,
    VoidTestNumbers::NEXT_DAY_AIR_SINGLE_PACKAGE_SHIPMENT_PROCESSED_AND_VOIDED,
]);

dataset('invalidShipmentNumbers', [
    'foo',
    '1Z',
    '1Zabc',
]);
