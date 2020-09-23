<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Payment;

use Rawilk\Ups\Entity\Address\Address;
use Rawilk\Ups\Entity\Payment\BillReceiver;
use Rawilk\Ups\Entity\Payment\BillShipper;
use Rawilk\Ups\Entity\Payment\BillThirdParty;
use Rawilk\Ups\Entity\Payment\BillThirdPartyShipper;
use Rawilk\Ups\Entity\Payment\ShipmentCharge;
use Rawilk\Ups\Entity\Payment\ThirdParty;
use Rawilk\Ups\Tests\TestCase;

class ShipmentChargeTest extends TestCase
{
    /** @test */
    public function converts_to_xml(): void
    {
        $expected = <<<XML
        <ShipmentCharge>
            <Type>01</Type>
            <ConsigneeBilled />
        </ShipmentCharge>
        XML;

        $charge = new ShipmentCharge([
            'type' => ShipmentCharge::TRANSPORTATION,
            'consignee_billed' => true,
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $charge->toSimpleXml(null, false)->asXML()
        );
    }

    /** @test */
    public function omits_bill_receiver_and_bill_third_party_if_bill_shipper_present(): void
    {
        $expected = <<<XML
        <ShipmentCharge>
            <Type>01</Type>
            <BillShipper>
                <AccountNumber>123</AccountNumber>
            </BillShipper>
        </ShipmentCharge>
        XML;

        $charge = new ShipmentCharge([
            'type' => ShipmentCharge::TRANSPORTATION,
            'consignee_billed' => true, // should be omitted too
            'bill_shipper' => new BillShipper([
                'account_number' => '123',
            ]),

            // should be omitted
            'bill_third_party' => new BillThirdParty([
                'bill_third_party_shipper' => new BillThirdPartyShipper([
                    'third_party' => new ThirdParty([
                        'address' => new Address([
                            'city' => 'foo',
                        ]),
                    ]),
                ]),
            ]),

            'bill_receiver' => new BillReceiver([
                'account_number' => '123',
                'address' => new Address([
                    'city' => 'foo',
                ]),
            ]),
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $charge->toSimpleXml(null, false)->asXML()
        );
    }

    /** @test */
    public function bill_third_party_is_omitted_if_bill_receiver_present(): void
    {
        $expected = <<<XML
        <ShipmentCharge>
            <Type>01</Type>
            <BillReceiver>
                <AccountNumber>123</AccountNumber>
                <Address>
                    <City>foo</City>
                </Address>
            </BillReceiver>
        </ShipmentCharge>
        XML;

        $charge = new ShipmentCharge([
            'type' => ShipmentCharge::TRANSPORTATION,

            // should be omitted
            'bill_third_party' => new BillThirdParty([
                'bill_third_party_shipper' => new BillThirdPartyShipper([
                    'third_party' => new ThirdParty([
                        'address' => new Address([
                            'city' => 'foo',
                        ]),
                    ]),
                ]),
            ]),

            'bill_receiver' => new BillReceiver([
                'account_number' => '123',
                'address' => new Address([
                    'city' => 'foo',
                ]),
            ]),
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $charge->toSimpleXml(null, false)->asXML()
        );
    }
}
