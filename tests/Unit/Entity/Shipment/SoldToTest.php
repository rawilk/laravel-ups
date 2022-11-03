<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Address\Address;
use Rawilk\Ups\Entity\Shipment\SoldTo;

it('converts to xml', function () {
    $expected = <<<'XML'
    <SoldTo>
        <CompanyName>foo</CompanyName>
        <Address>
            <City>foo</City>
        </Address>
    </SoldTo>
    XML;

    $soldTo = new SoldTo([
        'company_name' => 'foo',
        'address' => new Address([
            'city' => 'foo',
        ]),
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $soldTo->toSimpleXml(null, false)->asXML(),
    );
});
