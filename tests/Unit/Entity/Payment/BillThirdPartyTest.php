<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Payment;

use Rawilk\Ups\Entity\Address\Address;
use Rawilk\Ups\Entity\Payment\BillThirdParty;
use Rawilk\Ups\Entity\Payment\BillThirdPartyConsignee;
use Rawilk\Ups\Entity\Payment\BillThirdPartyShipper;
use Rawilk\Ups\Entity\Payment\ThirdParty;
use Rawilk\Ups\Tests\TestCase;

class BillThirdPartyTest extends TestCase
{
    /** @test */
    public function converts_to_xml(): void
    {
        $expected = <<<XML
        <BillThirdParty>
            <BillThirdPartyConsignee>
                <AccountNumber>123</AccountNumber>
                <ThirdParty>
                    <Address>
                        <City>foo</City>
                    </Address>
                </ThirdParty>
            </BillThirdPartyConsignee>
        </BillThirdParty>
        XML;

        $entity = new BillThirdParty([
            'bill_third_party_consignee' => new BillThirdPartyConsignee([
                'account_number' => '123',
                'third_party' => new ThirdParty([
                     'address' => new Address([
                         'city' => 'foo',
                     ]),
                ]),
            ]),
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }

    /** @test */
    public function omits_consignee_if_shipper_present(): void
    {
        $expected = <<<XML
        <BillThirdParty>
            <BillThirdPartyShipper>
                <AccountNumber>123</AccountNumber>
                <ThirdParty>
                    <Address>
                        <City>foo</City>
                    </Address>
                </ThirdParty>
            </BillThirdPartyShipper>
        </BillThirdParty>
        XML;

        $entity = new BillThirdParty([
            'bill_third_party_shipper' => new BillThirdPartyShipper([
                'account_number' => '123',
                'third_party' => new ThirdParty([
                    'address' => new Address([
                        'city' => 'foo',
                    ]),
                ]),
            ]),
            'bill_third_party_consignee' => new BillThirdPartyConsignee([
                'account_number' => '123',
                'third_party' => new ThirdParty([
                    'address' => new Address([
                        'city' => 'foo',
                    ]),
                ]),
            ]),
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }
}
