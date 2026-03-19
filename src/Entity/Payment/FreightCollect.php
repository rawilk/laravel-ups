<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Payment;

use Rawilk\Ups\Entity\Entity;

/**
 * @property BillReceiver $bill_receiver
 */
class FreightCollect extends Entity
{
    public function billReceiver(): string
    {
        return BillReceiver::class;
    }
}
