<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment;

use Rawilk\Ups\Entity\Entity;

/**
 * @property string $code
 * @property null|string $description
 */
class PackagingType extends Entity
{
    /** @var string */
    public const UPS_LETTER = '01';

    /** @var string */
    public const CUSTOMER_SUPPLIED_PACKAGE = '02';

    /** @var string */
    public const TUBE = '03';

    /** @var string */
    public const PAK = '04';

    /** @var string */
    public const UPS_EXPRESS_BOX = '21';

    /** @var string */
    public const UPS_25KG_BOX = '24';

    /** @var string */
    public const UPS_10KG_BOX = '25';

    /** @var string */
    public const PALLET = '30';

    /** @var string */
    public const SMALL_EXPRESS_BOX = '2a';

    /** @var string */
    public const MEDIUM_EXPRESS_BOX = '2b';

    /** @var string */
    public const LARGE_EXPRESS_BOX = '2c';

    /** @var string */
    public const FLATS = '56';

    /** @var string */
    public const PARCELS = '57';

    /** @var string */
    public const GPM = '58';

    /** @var string */
    public const FIRST_CLASS = '59';

    /** @var string */
    public const PRIORITY = '60';

    /** @var string */
    public const MACHINABLES = '61';

    /** @var string */
    public const IRREGULARS = '62';

    /** @var string */
    public const PARCEL_POST = '63';

    /** @var string */
    public const BPM_PARCEL = '64';

    /** @var string */
    public const MEDIA_MAIL = '65';

    /** @var string */
    public const BPM_FLAT = '66';

    /** @var string */
    public const STANDARD_FLAT = '67';

    /** @var string */
    public const DEFAULT_TYPE = self::CUSTOMER_SUPPLIED_PACKAGE;

    protected function booted(): void
    {
        $this->setAttribute('code', self::DEFAULT_TYPE);
    }
}
