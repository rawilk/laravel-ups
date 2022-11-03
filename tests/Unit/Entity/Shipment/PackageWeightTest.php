<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Shipment\PackageWeight;
use Rawilk\Ups\Entity\UnitOfMeasurement;

it('defaults uom to lbs', function () {
    $expected = <<<'XML'
    <PackageWeight>
        <UnitOfMeasurement>
            <Code>LBS</Code>
        </UnitOfMeasurement>
        <Weight>3</Weight>
    </PackageWeight>
    XML;

    $weight = new PackageWeight([
        'weight' => '3',
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $weight->toSimpleXml(null, false)->asXML(),
    );
});

test('uom can be customized', function () {
    $expected = <<<'XML'
    <PackageWeight>
        <UnitOfMeasurement>
            <Code>KGS</Code>
        </UnitOfMeasurement>
        <Weight>3</Weight>
    </PackageWeight>
    XML;

    $weight = new PackageWeight([
        'weight' => '3',
        'unit_of_measurement' => new UnitOfMeasurement([
            'code' => UnitOfMeasurement::KGS,
        ]),
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $weight->toSimpleXml(null, false)->asXML(),
    );
});
