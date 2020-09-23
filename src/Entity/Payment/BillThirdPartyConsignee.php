<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Payment;

use Rawilk\Ups\Entity\Entity;

/**
 * @property string $account_number
 *      The UPS account number of the third party consignee.
 * @property \Rawilk\Ups\Entity\Payment\ThirdParty $third_party
 */
class BillThirdPartyConsignee extends Entity
{
    public function thirdParty(): string
    {
        return ThirdParty::class;
    }
}
