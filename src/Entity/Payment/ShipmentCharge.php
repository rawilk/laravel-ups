<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Payment;

use Rawilk\Ups\Entity\Entity;

/**
 * @property string $type
 * @property null|\Rawilk\Ups\Entity\Payment\BillShipper $bill_shipper
 * @property null|\Rawilk\Ups\Entity\Payment\BillReceiver $bill_receiver
 * @property null|\Rawilk\Ups\Entity\Payment\BillThirdParty $bill_third_party
 * @property bool $consignee_billed
 *     Valid for shipment charge type of transportation only.
 */
class ShipmentCharge extends Entity
{
    // Shipment charge types:
    public const TRANSPORTATION = '01';

    public const DUTIES_AND_TAXES = '02';

    public const BROKER_OF_CHOICE = '03';

    protected $casts = [
        'consignee_billed' => 'boolean',
    ];

    protected function startingSimpleXml(): void
    {
        // Only one is allowed for the request.
        if ($this->bill_shipper) {
            unset($this->bill_receiver, $this->bill_third_party);
            $this->consignee_billed = false;
        } elseif ($this->bill_receiver) {
            unset($this->bill_third_party);
            $this->consignee_billed = false;
        } elseif ($this->bill_third_party) {
            $this->consignee_billed = false;
        }
    }

    public function billShipper(): string
    {
        return BillShipper::class;
    }

    public function billReceiver(): string
    {
        return BillReceiver::class;
    }

    public function billThirdParty(): string
    {
        return BillThirdParty::class;
    }
}
