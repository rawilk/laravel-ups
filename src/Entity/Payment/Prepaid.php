<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Payment;

use Rawilk\Ups\Entity\Entity;

/**
 * @property \Rawilk\Ups\Entity\Payment\BillShipper $bill_shipper
 */
class Prepaid extends Entity
{
    public function billShipper(): string
    {
        return BillShipper::class;
    }
}
