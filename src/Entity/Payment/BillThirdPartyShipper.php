<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Payment;

use Rawilk\Ups\Entity\Entity;

/**
 * @property string $account_number
 *      The account number of the third party shipper.
 * @property \Rawilk\Ups\Entity\Payment\ThirdParty $third_party
 */
class BillThirdPartyShipper extends Entity
{
    public function thirdParty(): string
    {
        return ThirdParty::class;
    }
}
