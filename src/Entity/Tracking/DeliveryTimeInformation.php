<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Tracking;

use Rawilk\Ups\Entity\Entity;

/**
 * @property null|string $package_bill_type
 * @property \Rawilk\Ups\Entity\Tracking\Pickup $pickup
 */
class DeliveryTimeInformation extends Entity
{
    public const DOCUMENT_ONLY = '02';

    public const NON_DOCUMENT = '03';

    public const PALLET = '04';

    public function pickup(): string
    {
        return Pickup::class;
    }
}
