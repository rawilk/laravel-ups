<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Payment;

use Rawilk\Ups\Entity\Payment\BillShipper;
use Rawilk\Ups\Entity\Payment\ItemizedPaymentInformation;
use Rawilk\Ups\Entity\Payment\ShipmentCharge;
use Rawilk\Ups\Tests\TestCase;

class ItemizedPaymentInformationTest extends TestCase
{
    /** @test */
    public function converts_to_xml(): void
    {
        $expected = <<<'XML'
        <ItemizedPaymentInformation>
            <SplitDutyVATIndicator />
            <ShipmentCharge>
                <Type>01</Type>
                <ConsigneeBilled />
            </ShipmentCharge>
            <ShipmentCharge>
                <Type>02</Type>
                <BillShipper>
                    <AccountNumber>123</AccountNumber>
                </BillShipper>
            </ShipmentCharge>
        </ItemizedPaymentInformation>
        XML;

        $entity = new ItemizedPaymentInformation([
            'split_duty_vat' => true,
            'shipment_charges' => [
                new ShipmentCharge([
                    'type' => ShipmentCharge::TRANSPORTATION,
                    'consignee_billed' => true,
                ]),
                new ShipmentCharge([
                    'type' => ShipmentCharge::DUTIES_AND_TAXES,
                    'bill_shipper' => new BillShipper([
                        'account_number' => '123',
                    ]),
                ]),
            ],
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }
}
