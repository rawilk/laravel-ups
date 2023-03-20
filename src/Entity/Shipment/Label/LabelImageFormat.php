<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment\Label;

use Rawilk\Ups\Entity\Entity;

/**
 * @property string $code
 */
class LabelImageFormat extends Entity
{
    // Valid formats:
    public const GIF = 'GIF';

    public const PNG = 'PNG';
}
