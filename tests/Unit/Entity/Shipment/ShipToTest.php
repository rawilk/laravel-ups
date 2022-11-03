<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Address\Address;
use Rawilk\Ups\Entity\Shipment\ShipTo;

it('converts to xml', function () {
    $expected = <<<'XML'
    <ShipTo>
        <Address>
            <City>foo</City>
        </Address>
        <CompanyName>foo</CompanyName>
        <AttentionName>bar</AttentionName>
        <EMailAddress>email@example.com</EMailAddress>
        <LocationID>foo</LocationID>
    </ShipTo>
    XML;

    $shipTo = new ShipTo([
        'company_name' => 'foo',
        'attention_name' => 'bar',
        'email_address' => 'email@example.com',
        'location_id' => 'foo',
        'address' => new Address([
            'city' => 'foo',
        ]),
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $shipTo->toSimpleXml(null, false)->asXML(),
    );
});

it('defaults address to new instance', function () {
    $expected = <<<'XML'
    <ShipTo>
        <Address />
    </ShipTo>
    XML;

    $shipTo = new ShipTo;

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $shipTo->toSimpleXml(null, false)->asXML(),
    );
});
