<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Payment;

use Rawilk\Ups\Entity\Entity;

/**
 * @property \Rawilk\Ups\Entity\Payment\ShipmentCharge[] $shipment_charges
 * @property bool $split_duty_vat
 *      The presence indicates the payer specified for Transportation Charges will pay
 *      transportation charges and any duties that apply to the shipment.
 */
class ItemizedPaymentInformation extends Entity
{
    protected $casts = [
        'split_duty_vat' => 'boolean',
    ];

    public function getSplitDutyVatXmlTag(): string
    {
        return 'SplitDutyVATIndicator';
    }

    public function getShipmentChargesXmlTag(): string
    {
        return 'ShipmentCharge';
    }

    public function shipmentCharge(): string
    {
        return ShipmentCharge::class;
    }
}
