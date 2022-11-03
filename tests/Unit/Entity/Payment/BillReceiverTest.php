<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Address\Address;
use Rawilk\Ups\Entity\Payment\BillReceiver;

it('converts to xml', function () {
    $expected = <<<'XML'
    <BillReceiver>
        <AccountNumber>123456</AccountNumber>
        <Address>
            <AddressLine1>123 Any street</AddressLine1>
            <City>Anytown</City>
        </Address>
    </BillReceiver>
    XML;

    $entity = new BillReceiver([
        'account_number' => '123456',
        'address' => new Address([
            'address_line1' => '123 Any street',
            'city' => 'Anytown',
        ]),
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $entity->toSimpleXml(null, false)->asXML(),
    );
});
