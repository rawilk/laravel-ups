<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment;

use Rawilk\Ups\Entity\Entity;

/**
 * @property string $code
 * @property null|string $description
 */
class Service extends Entity
{
    // Valid service codes:
    public const NEXT_DAY_AIR = '01';

    public const SECOND_DAY_AIR = '02';

    public const GROUND = '03';

    public const EXPRESS = '07';

    public const UPS_STANDARD = '11';

    public const THREE_DAY_SELECT = '12';

    public const NEXT_DAY_AIR_SAVER = '13';

    public const UPS_NEXT_DAY_AIR_EARLY = '14';

    public const UPS_WORLDWIDE_ECONOMY_DDU = '17';

    public const EXPRESS_PLUS = '54';

    public const SECOND_DAY_AIR_AM = '59';

    public const UPS_SAVER_70 = '65';

    public const UPS_ACCESS_POINT_ECONOMY = '70';

    public const FIRST_CLASS_MAIL = 'M2';

    public const PRIORITY_MAIL = 'M3';

    public const EXPEDITED_MAIL_INNOVATIONS = 'M4';

    public const PRIORITY_MAIL_INNOVATIONS = 'M5';

    public const ECONOMY_MAIL_INNOVATIONS = 'M6';

    public const MAIL_INNOVATIONS_RETURNS = 'M7';

    public const UPS_WORLDWIDE_EXPRESS_FREIGHT_MIDDAY = '71';

    public const UPS_WORLDWIDE_ECONOMY_DDP = '72';

    public const UPS_EXPRESS_12_00 = '74';

    public const UPS_TODAY_STANDARD = '82';

    public const UPS_TODAY_DEDICATED_COURIER = '83';

    public const UPS_TODAY_INTERCITY = '84';

    public const UPS_TODAY_EXPRESS = '85';

    public const UPS_TODAY_EXPRESS_SAVER = '86';

    public const UPS_WORLDWIDE_EXPRESS_FREIGHT = '96';

    public const DEFAULT_SERVICE_CODE = self::GROUND;

    protected function booted(): void
    {
        $this->setAttribute('code', self::DEFAULT_SERVICE_CODE);
    }
}
