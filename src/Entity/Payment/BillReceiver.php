<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Payment;

use Rawilk\Ups\Entity\Address\Address;
use Rawilk\Ups\Entity\Entity;

/**
 * @property string $account_number The UPS account number of Freight Collect.
 * @property null|\Rawilk\Ups\Entity\Address\Address $address
 */
class BillReceiver extends Entity
{
    public function address(): string
    {
        return Address::class;
    }
}
