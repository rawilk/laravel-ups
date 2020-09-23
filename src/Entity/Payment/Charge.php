<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Payment;

use Rawilk\Ups\Concerns\HasMonetaryValue;
use Rawilk\Ups\Entity\Entity;

/**
 * @property string $description
 */
class Charge extends Entity
{
    use HasMonetaryValue;

    protected function minMonetaryValue(): float
    {
        return 0;
    }
}
