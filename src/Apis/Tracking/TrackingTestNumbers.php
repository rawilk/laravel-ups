<?php

declare(strict_types=1);

namespace Rawilk\Ups\Apis\Tracking;

/*
 * These numbers can be used when testing to ensure your application can handle different tracking
 * scenarios.
 */
class TrackingTestNumbers
{
    /**
     * 2nd Day Air Delivered - All Activity
     *
     * @var string
     */
    public const ALL_2ND_DAY_AIR_DELIVERED = '1Z12345E0291980793';

    /**
     * World Wide Express Delivered - Last Activity
     *
     * @var string
     */
    public const LAST_WORLD_WIDE_EXPRESS_DELIVERED = '1Z12345E6692804405';

    /**
     * Delivered Ground Shipment - Last Activity
     * Response should return both packages in the shipment.
     *
     * @var string[]
     */
    public static $deliveredShipmentWithMultiplePackages = [
        'shipment_identification_number' => '1Z12345E0390515214',
        'second_package' => '1Z12345E0393657226',
    ];

    /** @var string */
    public const NO_TRACKING_INFORMATION_AVAILABLE = '1Z12345E1591910450';

    /** @var string */
    public const INVALID_TRACKING_NUMBER = '1Z12345E029198079';

    /** @var string */
    public const DELIVERED_NO_SIGNATURE = '1Z12345E0390105056';
}
