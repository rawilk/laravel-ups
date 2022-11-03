<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Address\Address;
use Rawilk\Ups\Entity\Shipment\Shipper;
use Rawilk\Ups\Exceptions\InvalidAttribute;

it('converts to xml', function () {
    $expected = <<<'XML'
    <Shipper>
        <Name>foo</Name>
        <AttentionName>foo</AttentionName>
        <CompanyDisplayableName>Foo</CompanyDisplayableName>
        <ShipperNumber>123456</ShipperNumber>
        <Address>
            <City>foo</City>
        </Address>
    </Shipper>
    XML;

    $shipper = new Shipper([
        'name' => 'foo',
        'attention_name' => 'foo',
        'company_displayable_name' => 'Foo',
        'shipper_number' => '123456',
        'address' => new Address([
            'city' => 'foo',
        ]),
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $shipper->toSimpleXml(null, false)->asXML(),
    );
});

it('auto truncates names', function () {
    $name = str_repeat('a', Shipper::MAX_NAME_LENGTH);
    $tooLong = str_repeat('a', Shipper::MAX_NAME_LENGTH + 1);

    $expected = <<<XML
    <Shipper>
        <Name>{$name}</Name>
        <AttentionName>{$name}</AttentionName>
        <CompanyDisplayableName>{$name}</CompanyDisplayableName>
    </Shipper>
    XML;

    $shipper = new Shipper([
        'name' => $tooLong,
        'attention_name' => $tooLong,
        'company_displayable_name' => $tooLong,
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $shipper->toSimpleXml(null, false)->asXML(),
    );
});

it('throws an exception for invalid shipper numbers', function (string $shipperNumber) {
    new Shipper([
        'shipper_number' => $shipperNumber,
    ]);
})->with('invalidShipperNumbers')->expectException(InvalidAttribute::class);

dataset('invalidShipperNumbers', [
    '',
    str_repeat('1', Shipper::SHIPPER_NUMBER_LENGTH - 1),
    str_repeat('1', Shipper::SHIPPER_NUMBER_LENGTH + 1)
]);
