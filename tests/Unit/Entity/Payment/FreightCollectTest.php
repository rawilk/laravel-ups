<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Address\Address;
use Rawilk\Ups\Entity\Payment\BillReceiver;
use Rawilk\Ups\Entity\Payment\FreightCollect;

it('converts to xml', function () {
    $expected = <<<'XML'
    <FreightCollect>
        <BillReceiver>
            <AccountNumber>123</AccountNumber>
            <Address>
                <City>foo</City>
            </Address>
        </BillReceiver>
    </FreightCollect>
    XML;

    $entity = new FreightCollect([
        'bill_receiver' => new BillReceiver([
            'account_number' => '123',
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
