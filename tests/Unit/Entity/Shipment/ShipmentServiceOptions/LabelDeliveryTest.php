<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions\LabelDelivery;

it('converts to xml', function () {
    $expected = <<<'XML'
    <LabelDelivery>
        <LabelLinksIndicator />
    </LabelDelivery>
    XML;

    $entity = new LabelDelivery([
        'label_links' => true,
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $entity->toSimpleXml(null, false)->asXML(),
    );
});
