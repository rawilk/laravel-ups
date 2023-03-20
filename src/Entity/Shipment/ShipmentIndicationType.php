<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment;

use Rawilk\Ups\Entity\Entity;

/**
 * @property string $code
 * @property null|string $description
 */
class ShipmentIndicationType extends Entity
{
    // Valid codes:
    public const HOLD_FOR_PICKUP = '01';

    public const UPS_ACCESS_POINT = '02';
}
