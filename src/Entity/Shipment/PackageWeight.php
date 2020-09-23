<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment;

use Rawilk\Ups\Entity\Entity;
use Rawilk\Ups\Entity\UnitOfMeasurement;

/**
 * @property string $weight
 * @property \Rawilk\Ups\Entity\UnitOfMeasurement $unit_of_measurement
 */
class PackageWeight extends Entity
{
    public function unitOfMeasurement(): string
    {
        return UnitOfMeasurement::class;
    }

    protected function booted(): void
    {
        // Let's default the UOM to a sensible default...
        $this->setAttribute('unit_of_measurement', new UnitOfMeasurement([
            'code' => UnitOfMeasurement::LBS,
        ]));
    }
}
