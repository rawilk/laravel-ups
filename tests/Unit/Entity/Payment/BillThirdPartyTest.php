<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Address\Address;
use Rawilk\Ups\Entity\Payment\BillThirdParty;
use Rawilk\Ups\Entity\Payment\BillThirdPartyConsignee;
use Rawilk\Ups\Entity\Payment\BillThirdPartyShipper;
use Rawilk\Ups\Entity\Payment\ThirdParty;

it('converts to xml', function () {
    $expected = <<<'XML'
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

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $entity->toSimpleXml(null, false)->asXML(),
    );
});

it('omits consignee if shipper is present', function () {
    $expected = <<<'XML'
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

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $entity->toSimpleXml(null, false)->asXML(),
    );
});
