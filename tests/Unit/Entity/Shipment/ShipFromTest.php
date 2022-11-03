<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Address\Address;
use Rawilk\Ups\Entity\Shipment\ShipFrom;
use Rawilk\Ups\Entity\Shipment\TaxIDType;

it('converts to xml', function () {
    $expected = <<<'XML'
    <ShipFrom>
        <CompanyName>foo</CompanyName>
        <AttentionName>foo</AttentionName>
        <PhoneNumber>123</PhoneNumber>
        <Address>
            <City>foo</City>
        </Address>
    </ShipFrom>
    XML;

    $shipFrom = new ShipFrom([
        'company_name' => 'foo',
        'attention_name' => 'foo',
        'phone_number' => '123',
        'address' => new Address([
            'city' => 'foo',
        ]),
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $shipFrom->toSimpleXml(null, false)->asXML(),
    );
});

it('can have tax id number', function () {
    $expected = <<<'XML'
    <ShipFrom>
        <TaxIdentificationNumber>123</TaxIdentificationNumber>
        <TaxIDType>
            <Code>EIN</Code>
        </TaxIDType>
    </ShipFrom>
    XML;

    $shipFrom = new ShipFrom([
        'tax_identification_number' => '123',
        'tax_id_type' => new TaxIDType([
            'code' => 'EIN',
        ]),
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $shipFrom->toSimpleXml(null, false)->asXML(),
    );
});

test('name gets truncated automatically', function () {
    $name = str_repeat('a', ShipFrom::MAX_NAME_LENGTH);
    $tooLong = str_repeat('a', ShipFrom::MAX_NAME_LENGTH + 1);

    $expected = <<<XML
    <ShipFrom>
        <CompanyName>{$name}</CompanyName>
        <AttentionName>{$name}</AttentionName>
    </ShipFrom>
    XML;

    $shipFrom = new ShipFrom([
        'company_name' => $tooLong,
        'attention_name' => $tooLong,
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $shipFrom->toSimpleXml(null, false)->asXML(),
    );
});
