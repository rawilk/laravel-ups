<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Shipment\Package;

it('converts to xml', function () {
    $expected = <<<'XML'
    <Package>
        <PackageWeight>
            <UnitOfMeasurement>
                <Code>LBS</Code>
            </UnitOfMeasurement>
        </PackageWeight>
        <PackageServiceOptions />
        <LargePackageIndicator />
    </Package>
    XML;

    $package = new Package([
        'is_large_package' => true,
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $package->toSimpleXml(null, false)->asXML(),
    );
});
