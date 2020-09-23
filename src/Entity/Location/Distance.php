<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Location;

use Rawilk\Ups\Entity\Entity;
use Rawilk\Ups\Entity\UnitOfMeasurement;

/**
 * @property float $value
 * @property \Rawilk\Ups\Entity\UnitOfMeasurement $unit_of_measurement
 */
class Distance extends Entity
{
    protected $casts = [
        'value' => 'float',
    ];

    public function unitOfMeasurement(): string
    {
        return UnitOfMeasurement::class;
    }
}
