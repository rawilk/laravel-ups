<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions;

use Rawilk\Ups\Entity\Entity;

/** @property int $dcis_type */
class DeliveryConfirmation extends Entity
{
    // Valid types:
    public const SIGNATURE_REQUIRED = 1;

    public const ADULT_SIGNATURE_REQUIRED = 2;

    public function signatureRequired(): self
    {
        $this->setAttribute('dcis_type', self::SIGNATURE_REQUIRED);

        return $this;
    }

    public function adultSignatureRequired(): self
    {
        $this->setAttribute('dcis_type', self::ADULT_SIGNATURE_REQUIRED);

        return $this;
    }

    public function getDcisTypeXmlTag(): string
    {
        return 'DCISType';
    }
}
