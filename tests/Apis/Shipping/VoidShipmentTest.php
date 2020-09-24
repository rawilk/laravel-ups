<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Apis\Shipping;

use Illuminate\Support\Collection;
use Rawilk\Ups\Apis\Shipping\Support\VoidTestNumbers;
use Rawilk\Ups\Apis\Shipping\VoidShipment;
use Rawilk\Ups\Entity\Shipment\PackageLevelResult;
use Rawilk\Ups\Exceptions\BadRequest;
use Rawilk\Ups\Tests\TestCase;

class VoidShipmentTest extends TestCase
{
    /**
     * @test
     * @dataProvider validShipmentVoidNumbers
     * @param string $shipmentIdentificationNumber
     */
    public function can_void_shipments(string $shipmentIdentificationNumber): void
    {
        $response = (new VoidShipment)
            ->usingShipmentIdentificationNumber($shipmentIdentificationNumber)
            ->void();

        self::assertTrue($response->status->successful());
        self::assertFalse($response->failed());
    }

    /** @test */
    public function can_void_the_lead_package(): void
    {
        $response = (new VoidShipment)
            ->usingShipmentIdentificationNumber(VoidTestNumbers::$partialVoidLeadPackage['shipment_id'])
            ->usingTrackingNumbers([VoidTestNumbers::$partialVoidLeadPackage['tracking_number']])
            ->void();

        self::assertTrue($response->status->successful());
        self::assertInstanceOf(Collection::class, $response->package_level_results);
        self::assertContainsOnlyInstancesOf(PackageLevelResult::class, $response->package_level_results);
        self::assertCount(1, $response->package_level_results);
        self::assertTrue($response->package_level_results->first()->voided());
    }

    /** @test */
    public function can_void_remaining_package(): void
    {
        $response = (new VoidShipment)
            ->usingShipmentIdentificationNumber(
                VoidTestNumbers::$multiPackageShipmentVoidRemainingPackage['shipment_id']
            )
            ->usingTrackingNumbers(
                [VoidTestNumbers::$multiPackageShipmentVoidRemainingPackage['tracking_number']]
            )
            ->void();

        self::assertTrue($response->status->successful());
        self::assertNull($response->package_level_results);
    }

    /** @test */
    public function can_void_all_remaining_packages(): void
    {
        $response = (new VoidShipment)
            ->usingShipmentIdentificationNumber(
                VoidTestNumbers::$multiPackageWithTwoRemainingUnvoided['shipment_id']
            )
            ->usingTrackingNumbers(
                VoidTestNumbers::$multiPackageWithTwoRemainingUnvoided['tracking_numbers']
            )
            ->void();

        self::assertTrue($response->status->successful());
        self::assertFalse($response->status->partiallyVoided());
        self::assertNull($response->package_level_results);
    }

    /** @test */
    public function can_void_packages_even_if_some_sent_packages_cannot_be_voided(): void
    {
        $response = (new VoidShipment)
            ->usingShipmentIdentificationNumber(
                VoidTestNumbers::$multiPackageShipmentWithNonVoidablePackage['shipment_id']
            )
            ->usingTrackingNumbers(
                VoidTestNumbers::$multiPackageShipmentWithNonVoidablePackage['tracking_numbers']
            )
            ->void();

        self::assertTrue($response->status->successful());
        self::assertTrue($response->status->partiallyVoided());
        self::assertCount(2, $response->package_level_results);

        /** @var \Rawilk\Ups\Entity\Shipment\PackageLevelResult $shouldBeVoided */
        $shouldBeVoided = $response->package_level_results
            ->firstWhere('tracking_number', VoidTestNumbers::$multiPackageShipmentWithNonVoidablePackage['tracking_numbers'][0]);

        self::assertTrue($shouldBeVoided->voided());

        /** @var \Rawilk\Ups\Entity\Shipment\PackageLevelResult $shouldNotBeVoided */
        $shouldNotBeVoided = $response->package_level_results
            ->firstWhere('tracking_number', VoidTestNumbers::$multiPackageShipmentWithNonVoidablePackage['tracking_numbers'][1]);

        self::assertTrue($shouldNotBeVoided->notVoided());
    }

    /** @test */
    public function expired_shipments_will_not_be_voided(): void
    {
        $response = (new VoidShipment)
            ->usingShipmentIdentificationNumber(
                VoidTestNumbers::GROUND_SINGLE_PACKAGE_SHIPMENT_VOIDING_EXPIRED
            )
            ->void();

        self::assertTrue($response->failed());
        self::assertNotEmpty($response->error_description);
        self::assertEquals('190101', $response->error_code);
    }

    /** @test */
    public function shipments_already_picked_up_will_not_be_voided(): void
    {
        $response = (new VoidShipment)
            ->usingShipmentIdentificationNumber(
                VoidTestNumbers::SHIPMENT_ALREADY_PICKED_UP
            )
            ->void();

        self::assertTrue($response->failed());
        self::assertNotEmpty($response->error_description);
        self::assertEquals('190103', $response->error_code);
    }

    /** @test */
    public function shipments_older_than_28_days_will_not_be_voided(): void
    {
        $response = (new VoidShipment)
            ->usingShipmentIdentificationNumber(
                VoidTestNumbers::SHIPMENT_OLDER_THAN_28_DAYS
            )
            ->void();

        self::assertTrue($response->failed());
        self::assertNotEmpty($response->error_description);
        self::assertEquals('190101', $response->error_code);
    }

    /** @test */
    public function a_package_not_in_a_shipment_will_not_be_voided(): void
    {
        $response = (new VoidShipment)
            ->usingShipmentIdentificationNumber(
                VoidTestNumbers::$trackingNumberNotInShipment['shipment_id']
            )
            ->usingTrackingNumbers(
                [VoidTestNumbers::$trackingNumberNotInShipment['tracking_number']]
            )
            ->void();

        self::assertTrue($response->failed());
        self::assertNotEmpty($response->error_description);
        self::assertEquals('190110', $response->error_code);
    }

    /** @test */
    public function return_shipments_cannot_be_voided_at_the_package_level(): void
    {
        $response = (new VoidShipment)
            ->usingShipmentIdentificationNumber(
                VoidTestNumbers::$returnShipmentFailAtPackageLevel['shipment_id']
            )
            ->usingTrackingNumbers(
                [VoidTestNumbers::$returnShipmentFailAtPackageLevel['tracking_number']]
            )
            ->void();

        self::assertTrue($response->failed());
        self::assertNotEmpty($response->error_description);
        self::assertEquals('190112', $response->error_code);
    }

    /** @test */
    public function shipment_identification_number_is_required(): void
    {
        $this->expectException(BadRequest::class);

        (new VoidShipment)->void();
    }

    /**
     * @test
     * @dataProvider invalidShipmentIdNumbers
     * @param string $id
     */
    public function requires_a_valid_shipment_identification_number(string $id): void
    {
        $this->expectException(BadRequest::class);

        (new VoidShipment)->usingShipmentIdentificationNumber($id)->void();
    }

    /**
     * @test
     * @dataProvider invalidShipmentIdNumbers
     * @param string $id
     */
    public function requires_valid_tracking_numbers(string $id): void
    {
        $this->expectException(BadRequest::class);

        (new VoidShipment)
            ->usingShipmentIdentificationNumber(VoidTestNumbers::GROUND_SINGLE_PACKAGE_SHIPMENT_PROCESSED_AND_VOIDED)
            ->usingTrackingNumbers([$id])
            ->void();
    }

    public function validShipmentVoidNumbers(): array
    {
        return [
            [VoidTestNumbers::GROUND_SINGLE_PACKAGE_SHIPMENT_PROCESSED_AND_VOIDED],
            [VoidTestNumbers::SHIPMENT_VOIDED_AT_SHIPMENT_LEVEL],
            [VoidTestNumbers::SHIPMENT_VOIDED_AT_SHIPMENT_LEVEL2],
            [VoidTestNumbers::NEXT_DAY_AIR_SINGLE_PACKAGE_SHIPMENT_PROCESSED_AND_VOIDED],
        ];
    }

    public function invalidShipmentIdNumbers(): array
    {
        return [
            ['foo'],
            ['1Z'],
            ['1Zabc'],
        ];
    }
}
