<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment;

use Rawilk\Ups\Entity\Entity;
use Rawilk\Ups\Entity\UnitOfMeasurement;

/**
 * @property int $length
 * @property int $width
 * @property int $height
 * @property \Rawilk\Ups\Entity\UnitOfMeasurement $unit_of_measurement
 */
class Dimensions extends Entity
{
    public function unitOfMeasurement(): string
    {
        return UnitOfMeasurement::class;
    }
}
