<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Shipment\PackageServiceOptions\HazMatPackageInformation;

it('converts to xml', function () {
    $expected = <<<'XML'
    <HazMatPackageInformation>
        <AllPackedInOneIndicator />
        <OverPackedIndicator />
        <QValue>3</QValue>
        <OuterPackagingType>foo</OuterPackagingType>
    </HazMatPackageInformation>
    XML;

    $entity = new HazMatPackageInformation([
        'all_packed_in_one' => true,
        'over_packed' => true,
        'q_value' => '3',
        'outer_packaging_type' => 'foo',
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $entity->toSimpleXml(null, false)->asXML(),
    );
});
