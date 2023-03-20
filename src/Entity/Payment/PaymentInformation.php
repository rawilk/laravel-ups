<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Payment;

use Rawilk\Ups\Entity\Entity;

/**
 * @property null|\Rawilk\Ups\Entity\Payment\Prepaid $prepaid
 * @property null|\Rawilk\Ups\Entity\Payment\BillThirdParty $bill_third_party
 * @property null|\Rawilk\Ups\Entity\Payment\FreightCollect $freight_collect
 * @property bool $consignee_billed
 */
class PaymentInformation extends Entity
{
    protected $casts = [
        'consignee_billed' => 'boolean',
    ];

    /**
     * Convenience method to use "prepaid bill shipper".
     *
     * @return $this
     */
    public static function prepaidForAccount(string $accountNumber): self
    {
        return new static([
            'prepaid' => new Prepaid([
                'bill_shipper' => new BillShipper([
                    'account_number' => $accountNumber,
                ]),
            ]),
        ]);
    }

    protected function startingSimpleXml(): void
    {
        // Only one of these elements can be present for a request.
        if ($this->prepaid) {
            unset($this->bill_third_party, $this->freight_collect);
            $this->consignee_billed = false;
        } elseif ($this->bill_third_party) {
            unset($this->freight_collect);
            $this->consignee_billed = false;
        } elseif ($this->freight_collect) {
            $this->consignee_billed = false;
        }
    }

    public function billThirdParty(): string
    {
        return BillThirdParty::class;
    }

    public function freightCollect(): string
    {
        return FreightCollect::class;
    }
}
