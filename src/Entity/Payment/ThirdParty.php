<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Payment;

use Rawilk\Ups\Entity\Address\Address;
use Rawilk\Ups\Entity\Entity;

/**
 * @property \Rawilk\Ups\Entity\Address\Address $address
 */
class ThirdParty extends Entity
{
    public function address(): string
    {
        return Address::class;
    }
}
