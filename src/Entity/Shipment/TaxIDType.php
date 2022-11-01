<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment;

use Rawilk\Ups\Entity\Entity;

/**
 * @property string $code
 * @property null|string $description
 */
class TaxIDType extends Entity
{
    // Tax ID type codes:
    public const EIN = 'EIN';

    public const DNS = 'DNS';

    public const FGN = 'FGN';
}
