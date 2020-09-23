<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Payment;

use Rawilk\Ups\Entity\Entity;

/**
 * @property null|string $account_number
 *      UPS account number. Must be the same account number as the one provided in Shipment/Shipper/ShipperNumber attribute.
 * @property null|\Rawilk\Ups\Entity\Payment\CreditCard $credit_card
 */
class BillShipper extends Entity
{
    public function startingSimpleXml(): void
    {
        // Only one is allowed in the request.
        if ($this->account_number) {
            unset($this->credit_card);
        }
    }

    public function creditCard(): string
    {
        return CreditCard::class;
    }
}
