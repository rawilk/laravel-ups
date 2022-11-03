<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Shipment\BillingWeight;
use Rawilk\Ups\Entity\UnitOfMeasurement;

it('defaults uom to lbs', function () {
    $expected = <<<'XML'
    <BillingWeight>
        <UnitOfMeasurement>
            <Code>LBS</Code>
        </UnitOfMeasurement>
        <Weight>3</Weight>
    </BillingWeight>
    XML;

    $entity = new BillingWeight([
        'weight' => '3',
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $entity->toSimpleXml(null, false)->asXML(),
    );
});

test('uom can be customized', function () {
    $expected = <<<'XML'
    <BillingWeight>
        <UnitOfMeasurement>
            <Code>KGS</Code>
        </UnitOfMeasurement>
        <Weight>3</Weight>
    </BillingWeight>
    XML;

    $entity = new BillingWeight([
        'weight' => '3',
        'unit_of_measurement' => new UnitOfMeasurement([
            'code' => UnitOfMeasurement::KGS,
        ]),
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $entity->toSimpleXml(null, false)->asXML(),
    );
});
