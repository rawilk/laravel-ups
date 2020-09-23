<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Location;

use Rawilk\Ups\Entity\Entity;

/**
 * @property \Rawilk\Ups\Entity\Location\StandardHours $standard_hours
 */
class OperatingHours extends Entity
{
    public function standardHours(): string
    {
        return StandardHours::class;
    }
}
