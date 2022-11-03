<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Shipment\AlternateDeliveryAddress;

it('converts to xml', function () {
    $expected = <<<'XML'
    <AlternateDeliveryAddress>
        <Address />
        <Name>Google</Name>
        <UPSAccessPointID>123</UPSAccessPointID>
    </AlternateDeliveryAddress>
    XML;

    $entity = new AlternateDeliveryAddress([
        'name' => 'Google',
        'ups_access_point_id' => '123',
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $entity->toSimpleXml(null, false)->asXML(),
    );
});

it('truncates names that are too long', function () {
    $tooLong = str_repeat('a', 36);
    $name = str_repeat('a', 35);

    $expected = <<<XML
    <AlternateDeliveryAddress>
        <Address />
        <Name>{$name}</Name>
    </AlternateDeliveryAddress>
    XML;

    $entity = new AlternateDeliveryAddress([
        'name' => $tooLong,
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $entity->toSimpleXml(null, false)->asXML(),
    );
});
