<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment\PackageServiceOptions;

use Rawilk\Ups\Concerns\HasMonetaryValue;
use Rawilk\Ups\Entity\Entity;

class InsuredValue extends Entity
{
    use HasMonetaryValue;
}
