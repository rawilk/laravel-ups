<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Shipment\Receipt\ImageFormat;
use Rawilk\Ups\Entity\Shipment\Receipt\ReceiptSpecification;

it('converts to xml', function () {
    $expected = <<<'XML'
    <ReceiptSpecification>
        <ImageFormat>
            <Code>HTML</Code>
        </ImageFormat>
    </ReceiptSpecification>
    XML;

    $entity = new ReceiptSpecification([
        'image_format' => new ImageFormat([
            'code' => ImageFormat::HTML,
        ]),
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $entity->toSimpleXml(null, false)->asXML(),
    );
});
