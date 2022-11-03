<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Shipment\PackagingType;

test('code has a default', function () {
    $default = PackagingType::DEFAULT_TYPE;

    $expected = <<<XML
    <PackagingType>
        <Code>{$default}</Code>
        <Description>Foo</Description>
    </PackagingType>
    XML;

    $entity = new PackagingType([
        'description' => 'Foo',
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $entity->toSimpleXml(null, false)->asXML(),
    );
});
