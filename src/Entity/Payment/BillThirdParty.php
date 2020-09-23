<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Payment;

use Rawilk\Ups\Entity\Entity;

/**
 * @property null|\Rawilk\Ups\Entity\Payment\BillThirdPartyShipper $bill_third_party_shipper
 * @property null|\Rawilk\Ups\Entity\Payment\BillThirdPartyConsignee $bill_third_party_consignee
 */
class BillThirdParty extends Entity
{
    public function startingSimpleXml(): void
    {
        // Only one is allowed in the request.
        if ($this->bill_third_party_shipper) {
            unset($this->bill_third_party_consignee);
        }
    }

    public function billThirdPartyConsignee(): string
    {
        return BillThirdPartyConsignee::class;
    }

    public function billThirdPartyShipper(): string
    {
        return BillThirdPartyShipper::class;
    }
}
