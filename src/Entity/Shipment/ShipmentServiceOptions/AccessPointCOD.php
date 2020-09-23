<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions;

use Rawilk\Ups\Concerns\HasMonetaryValue;
use Rawilk\Ups\Entity\Entity;

class AccessPointCOD extends Entity
{
    use HasMonetaryValue;
}
