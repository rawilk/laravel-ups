<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment;

/**
 * @property string $name Retail location name
 * @property string $ups_access_point_id
 */
class AlternateDeliveryAddress extends ShipTo
{
    /** @var int */
    protected const MAX_NAME_LENGTH = 35;

    public function setNameAttribute(string $name): void
    {
        if (strlen($name) > self::MAX_NAME_LENGTH) {
            $name = substr($name, 0, self::MAX_NAME_LENGTH);
        }

        $this->attributes['name'] = $name;
    }

    public function getUpsAccessPointIdXmlTag(): string
    {
        return 'UPSAccessPointID';
    }
}
