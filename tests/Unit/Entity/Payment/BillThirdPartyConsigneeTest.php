<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Address\Address;
use Rawilk\Ups\Entity\Payment\BillThirdPartyConsignee;
use Rawilk\Ups\Entity\Payment\ThirdParty;

it('converts to xml', function () {
    $expected = <<<'XML'
    <BillThirdPartyConsignee>
        <AccountNumber>123</AccountNumber>
        <ThirdParty>
            <Address>
                <City>foo</City>
            </Address>
        </ThirdParty>
    </BillThirdPartyConsignee>
    XML;

    $entity = new BillThirdPartyConsignee([
        'account_number' => '123',
        'third_party' => new ThirdParty([
            'address' => new Address([
                'city' => 'foo',
            ]),
        ]),
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $entity->toSimpleXml(null, false)->asXML(),
    );
});
