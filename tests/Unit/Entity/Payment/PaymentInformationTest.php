<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Address\Address;
use Rawilk\Ups\Entity\Payment\BillReceiver;
use Rawilk\Ups\Entity\Payment\BillShipper;
use Rawilk\Ups\Entity\Payment\BillThirdParty;
use Rawilk\Ups\Entity\Payment\BillThirdPartyShipper;
use Rawilk\Ups\Entity\Payment\FreightCollect;
use Rawilk\Ups\Entity\Payment\PaymentInformation;
use Rawilk\Ups\Entity\Payment\Prepaid;
use Rawilk\Ups\Entity\Payment\ThirdParty;

it('converts to xml', function () {
    $expected = <<<'XML'
    <PaymentInformation>
        <ConsigneeBilled />
    </PaymentInformation>
    XML;

    $entity = new PaymentInformation([
        'consignee_billed' => true,
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $entity->toSimpleXml(null, false)->asXML(),
    );
});

it('omits bill third party and freight collect elements if prepaid element is present', function () {
    $expected = <<<'XML'
    <PaymentInformation>
        <Prepaid>
            <BillShipper>
                <AccountNumber>123</AccountNumber>
            </BillShipper>
        </Prepaid>
    </PaymentInformation>
    XML;

    $entity = new PaymentInformation([
        'consignee_billed' => true, // should also be omitted

        'prepaid' => new Prepaid([
            'bill_shipper' => new BillShipper([
                'account_number' => '123',
            ]),
        ]),

        // should be omitted
        'bill_third_party' => new BillThirdParty([
            'bill_third_party_shipper' => new BillThirdPartyShipper([
                'account_number' => '123',
                'third_party' => new ThirdParty([
                    'address' => new Address([
                        'city' => 'foo',
                    ]),
                ]),
            ]),
        ]),

        'freight_collect' => new FreightCollect([
            'bill_receiver' => new BillReceiver([
                'account_number' => 'foo',
            ]),
        ]),
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $entity->toSimpleXml(null, false)->asXML(),
    );
});

it('omits freight collect if bill third party element is present', function () {
    $expected = <<<'XML'
    <PaymentInformation>
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
    </PaymentInformation>
    XML;

    $entity = new PaymentInformation([
        'consignee_billed' => true, // should also be omitted

        // should be omitted
        'bill_third_party' => new BillThirdParty([
            'bill_third_party_shipper' => new BillThirdPartyShipper([
                'account_number' => '123',
                'third_party' => new ThirdParty([
                    'address' => new Address([
                        'city' => 'foo',
                    ]),
                ]),
            ]),
        ]),

        'freight_collect' => new FreightCollect([
            'bill_receiver' => new BillReceiver([
                'account_number' => 'foo',
            ]),
        ]),
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $entity->toSimpleXml(null, false)->asXML(),
    );
});
