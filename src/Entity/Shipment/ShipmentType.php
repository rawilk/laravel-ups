<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment;

use Rawilk\Ups\Entity\Entity;

/**
 * @property string $code
 *      Indicates the type of shipment being tracked during Reference number tracking.
 * @property null|string $description
 */
class ShipmentType extends Entity
{
    // Valid codes:
    public const PACKAGE = '01'; // default

    public const FREIGHT = '02';

    public const MAIL_INNOVATIONS = '03';

    protected function booted(): void
    {
        $this->setAttribute('code', self::PACKAGE);
    }
}
