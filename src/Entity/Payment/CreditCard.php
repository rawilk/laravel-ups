<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Payment;

use Rawilk\Ups\Entity\Address\Address;
use Rawilk\Ups\Entity\Entity;

/**
 * @property string $type
 * @property string $number
 * @property string $expiration_date
 * @property string $security_code
 * @property \Rawilk\Ups\Entity\Address\Address $address
 */
class CreditCard extends Entity
{
    public function address(): string
    {
        return Address::class;
    }
}
