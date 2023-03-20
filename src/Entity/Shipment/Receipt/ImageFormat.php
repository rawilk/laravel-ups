<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment\Receipt;

use Rawilk\Ups\Entity\Entity;

/**
 * @property string $code
 * @property null|string $description
 */
class ImageFormat extends Entity
{
    // Valid codes:
    public const EPL = 'EPL';

    public const SPL = 'SPL';

    public const ZPL = 'ZPL';

    public const STARPL = 'STARPL';

    public const HTML = 'HTML';
}
