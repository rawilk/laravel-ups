<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment;

use Rawilk\Ups\Entity\Entity;
use Rawilk\Ups\Entity\Shipment\Label\LabelImage;

/**
 * PackageResult is an entity returned from a ShipAccept response.
 *
 * @property string $tracking_number
 * @property null|\Rawilk\Ups\Entity\Shipment\Label\LabelImage $label_image
 */
class PackageResult extends Entity
{
    public function labelImage(): string
    {
        return LabelImage::class;
    }
}
