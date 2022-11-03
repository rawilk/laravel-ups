<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions\LabelDelivery;
use Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions\LabelMethod;

it('converts to xml', function () {
    $expected = <<<'XML'
    <LabelDelivery>
        <Code>01</Code>
        <Description>foo</Description>
    </LabelDelivery>
    XML;

    $entity = new LabelDelivery([
        'code' => LabelMethod::PRINT_AND_MAIL,
        'description' => 'foo',
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $entity->toSimpleXml(null, false)->asXML(),
    );
});

it('auto truncates the description', function () {
    $description = str_repeat('a', LabelMethod::MAX_DESCRIPTION_LENGTH);
    $tooLong = str_repeat('a', LabelMethod::MAX_DESCRIPTION_LENGTH + 1);

    $expected = <<<XML
    <LabelMethod>
        <Code>01</Code>
        <Description>{$description}</Description>
    </LabelMethod>
    XML;

    $entity = new LabelMethod([
        'code' => LabelMethod::PRINT_AND_MAIL,
        'description' => $tooLong,
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $entity->toSimpleXml(null, false)->asXML(),
    );
});
