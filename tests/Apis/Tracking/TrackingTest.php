<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Apis\Tracking;

use Carbon\Carbon;
use Rawilk\Ups\Apis\Tracking\Tracking;
use Rawilk\Ups\Apis\Tracking\TrackingTestNumbers;
use Rawilk\Ups\Entity\Activity\Activity;
use Rawilk\Ups\Entity\Shipment\Package;
use Rawilk\Ups\Entity\Shipment\ReferenceNumber;
use Rawilk\Ups\Entity\Shipment\Shipment;
use Rawilk\Ups\Tests\TestCase;

class TrackingTest extends TestCase
{
    /** @test */
    public function can_make_api_calls(): void
    {
        $response = (new Tracking)
            ->usingTrackingNumber(TrackingTestNumbers::ALL_2ND_DAY_AIR_DELIVERED)
            ->track();

        self::assertInstanceOf(Shipment::class, $response->shipment);
        self::assertCount(1, $response->shipment->packages);
        self::assertContainsOnlyInstancesOf(Package::class, $response->shipment->packages);

        self::assertInstanceOf(Carbon::class, $response->shipment->pickup_date);
        self::assertTrue($response->shipment->isPickedUp());

        self::assertInstanceOf(ReferenceNumber::class, $response->shipment->reference_number);
        self::assertEquals('01', $response->shipment->reference_number->code);

        /** @var \Rawilk\Ups\Entity\Shipment\Package $firstPackage */
        $firstPackage = $response->shipment->packages->first();

        self::assertTrue($firstPackage->isDelivered());
        self::assertSame('HELEN SMITH', $firstPackage->signedForByName());
    }

    /** @test */
    public function can_determine_if_delivered_from_last_activity_only(): void
    {
        $response = (new Tracking)
            ->usingTrackingNumber(TrackingTestNumbers::LAST_WORLD_WIDE_EXPRESS_DELIVERED)
            ->lastActivity()
            ->track();

        /** @var \Rawilk\Ups\Entity\Shipment\Package $package */
        $package = $response->shipment->packages->first();

        self::assertCount(1, $package->activities);
        self::assertContainsOnlyInstancesOf(Activity::class, $package->activities);
        self::assertTrue($package->isDelivered());
        self::assertSame('DAVID ADAMS', $package->signedForByName());
    }

    /** @test */
    public function can_get_tracking_info_for_multiple_packages_in_shipment(): void
    {
        $response = (new Tracking)
            ->usingTrackingNumber(TrackingTestNumbers::$deliveredShipmentWithMultiplePackages['shipment_identification_number'])
            ->track();

        self::assertSame(
            TrackingTestNumbers::$deliveredShipmentWithMultiplePackages['shipment_identification_number'],
            $response->shipment->shipment_identification_number
        );

        self::assertCount(2, $response->shipment->packages);
        self::assertTrue($response->shipment->isPickedUp());

        /** @var \Rawilk\Ups\Entity\Shipment\Package $firstPackage */
        $firstPackage = $response->shipment->packages->first();
        self::assertSame(
            TrackingTestNumbers::$deliveredShipmentWithMultiplePackages['shipment_identification_number'],
            $firstPackage->tracking_number
        );
        self::assertTrue($firstPackage->isDelivered());

        /** @var Package $secondPackage */
        $secondPackage = $response->shipment->packages[1];
        self::assertSame(
            TrackingTestNumbers::$deliveredShipmentWithMultiplePackages['second_package'],
            $secondPackage->tracking_number
        );
        self::assertTrue($secondPackage->isDelivered());
    }

    /** @test */
    public function can_determine_if_no_tracking_information_available(): void
    {
        $response = (new Tracking)
            ->usingTrackingNumber(TrackingTestNumbers::NO_TRACKING_INFORMATION_AVAILABLE)
            ->track();

        self::assertTrue($response->failed());
        self::assertSame('151044', $response->error_code);
        self::assertTrue($response->noTrackingInformationAvailable());
        self::assertFalse($response->invalidTrackingNumber());
    }

    /** @test */
    public function can_determine_if_invalid_tracking_number(): void
    {
        $response = (new Tracking)
            ->usingTrackingNumber(TrackingTestNumbers::INVALID_TRACKING_NUMBER)
            ->track();

        self::assertTrue($response->failed());
        self::assertSame('151018', $response->error_code);
        self::assertTrue($response->invalidTrackingNumber());
        self::assertFalse($response->noTrackingInformationAvailable());
    }

    /** @test */
    public function can_be_delivered_with_no_signature(): void
    {
        $response = (new Tracking)
            ->usingTrackingNumber(TrackingTestNumbers::DELIVERED_NO_SIGNATURE)
            ->track();

        self::assertTrue($response->shipment->isPickedUp());

        /** @var \Rawilk\Ups\Entity\Shipment\Package $package */
        $package = $response->shipment->packages->first();

        self::assertTrue($package->isDelivered());
        self::assertNull($package->signedForByName());
    }
}
