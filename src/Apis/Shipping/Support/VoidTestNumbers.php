<?php

declare(strict_types=1);

namespace Rawilk\Ups\Apis\Shipping\Support;

class VoidTestNumbers
{
    /** @var string */
    public const GROUND_SINGLE_PACKAGE_SHIPMENT_PROCESSED_AND_VOIDED = '1Z12345E0390817264';

    /** @var string */
    public const NEXT_DAY_AIR_SINGLE_PACKAGE_SHIPMENT_PROCESSED_AND_VOIDED = '1Z12345E0193075279';

    /**
     * Single package shipment sent via UPS Ground for which the allotted time period
     * for voiding the shipment has expired.
     * Error: 190101
     *
     * @var string
     */
    public const GROUND_SINGLE_PACKAGE_SHIPMENT_VOIDING_EXPIRED = '1Z12345E0392508488';

    /**
     * Shipment that has already been picked up by the UPS service provider.
     * Error: 190103
     *
     * @var string
     */
    public const SHIPMENT_ALREADY_PICKED_UP = '1Z12345E1290420899';

    /**
     * A successful shipment voided XML response will be returned for a shipment
     * level void request.
     *
     * @var string
     */
    public const SHIPMENT_VOIDED_AT_SHIPMENT_LEVEL = '1Z12345E0390856432';

    public const SHIPMENT_VOIDED_AT_SHIPMENT_LEVEL2 = '1Z12345E0193081456';

    /**
     * The intention of this test case is to prove one can void the lead package in a shipment
     * and the shipment ID will survive the void of the lead package.
     */
    public static array $partialVoidLeadPackage = [
        'shipment_id' => '1Z12345E1234567890',
        'tracking_number' => '1Z12345E1234567890',
    ];

    /**
     * Multi-package shipment with all, save one, of the packages already voided.
     * The request will void the remaining package. The shipment will be completely
     * voided.
     *
     * @var string[]
     */
    public static array $multiPackageShipmentVoidRemainingPackage = [
        'shipment_id' => '1Z12345E2318693258',
        'tracking_number' => '1Z12345E0193072168 ',
    ];

    /**
     * Multi-package shipment with a package that cannot be voided. A successful
     * shipment partially voided XML response will be returned for a package level void request.
     * Tracking number 1Z12345E1593518308 will not be voided.
     */
    public static array $multiPackageShipmentWithNonVoidablePackage = [
        'shipment_id' => '1Z12345E1234567890',
        'tracking_numbers' => [
            '1Z12345E8635481269',
            '1Z12345E1593518308',
        ],
    ];

    /**
     * Multi-package shipment with two packages that remain un-voided.
     * A successful shipment voided XML response will be returned for a
     * package level void request. The request will void all of the remaining
     * packages in the shipment. The shipment will be completely voided.
     */
    public static array $multiPackageWithTwoRemainingUnvoided = [
        'shipment_id' => '1Z12345E2318693258',
        'tracking_numbers' => [
            '1Z12345E0390819985',
            '1Z12345E0193078563',
        ],
    ];

    /**
     * A shipment uploaded more than 28 days previously.
     * A failed XML response will be returned: Time for voiding has expired.
     * Error: 190101
     *
     * @var string
     */
    public const SHIPMENT_OLDER_THAN_28_DAYS = '1Z12345E8793628675';

    /**
     * This tracking number does not belong to the shipment.
     * Package void will fail to void any packages when an invalid
     * package tracking number is provided.
     * Error: 190110
     *
     * @var string[]
     */
    public static array $trackingNumberNotInShipment = [
        'shipment_id' => '1Z12345E1234567890',
        'tracking_number' => '1Z12345E0392508253',
    ];

    /**
     * Return shipments cannot be voided at the package level.
     * Error: 190112
     *
     * @var string[]
     */
    public static array $returnShipmentFailAtPackageLevel = [
        'shipment_id' => '1Z12345E2318693258',
        'tracking_number' => '1Z12345E0392506486',
    ];
}
