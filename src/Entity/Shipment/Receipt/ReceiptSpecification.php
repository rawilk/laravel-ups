<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment\Receipt;

use Rawilk\Ups\Entity\Entity;

/**
 * @property \Rawilk\Ups\Entity\Shipment\Receipt\ImageFormat $image_format
 */
class ReceiptSpecification extends Entity
{
    public function imageFormat(): string
    {
        return ImageFormat::class;
    }
}
